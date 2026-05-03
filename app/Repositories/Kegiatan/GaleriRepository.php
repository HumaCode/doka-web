<?php

namespace App\Repositories\Kegiatan;

use App\Models\Kegiatan\Kegiatan;

class GaleriRepository implements GaleriRepositoryInterface
{
    /**
     * Get all photos for gallery.
     */
    public function getAllPhotos(array $filters = [])
    {
        $query = Kegiatan::with(['unitKerja', 'media']);

        if (!empty($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }

        $kegiatans = $query->latest()->get();
        $photos = collect();

        // 1. Real photos
        foreach ($kegiatans as $kegiatan) {
            foreach ($kegiatan->getMedia('foto_kegiatan') as $media) {
                $photos->push((object)[
                    'id' => 'media_' . $media->id,
                    'url' => $media->getUrl(),
                    'thumb' => $media->getUrl(),
                    'kegiatan' => $kegiatan->judul,
                    'kegiatanId' => $kegiatan->id,
                    'unit' => $kegiatan->unitKerja->nama_instansi ?? 'Umum',
                    'tanggal' => $kegiatan->tanggal ? $kegiatan->tanggal->format('d M Y') : '-',
                    'bulan' => $kegiatan->tanggal ? $kegiatan->tanggal->format('m') : null,
                    'size' => round($media->size / 1024 / 1024, 1),
                    'caption' => $media->getCustomProperty('caption') ?? $kegiatan->judul,
                    'is_main' => $media->getCustomProperty('is_main') ?? false,
                    'gradId' => (crc32($media->id) % 8),
                    'emoji' => ['📷','📸','🎞','🖼','📅','👥','🏛','📋'][(crc32($media->id) % 8)],
                ]);
            }
        }

        // 2. Mock placeholders if sparse
        if ($photos->count() < 40) {
            $kegiatansWithoutMedia = $kegiatans->filter(fn($k) => $k->media->count() === 0);
            foreach ($kegiatansWithoutMedia as $kegiatan) {
                $count = (abs(crc32($kegiatan->id)) % 2) + 1; // Consistent count (1 or 2)
                for ($i = 0; $i < $count; $i++) {
                    if ($photos->count() >= 50) break;
                    
                    $mockId = 'mock_' . $kegiatan->id . '_' . $i;
                    $gradId = (crc32($mockId) % 8);
                    $photos->push((object)[
                        'id' => $mockId,
                        'url' => null,
                        'thumb' => null,
                        'kegiatan' => $kegiatan->judul,
                        'kegiatanId' => $kegiatan->id,
                        'unit' => $kegiatan->unitKerja->nama_instansi ?? 'Umum',
                        'tanggal' => $kegiatan->tanggal ? $kegiatan->tanggal->format('d M Y') : '-',
                        'bulan' => $kegiatan->tanggal ? $kegiatan->tanggal->format('m') : null,
                        'size' => round((abs(crc32($mockId)) % 20 + 5) / 10, 1),
                        'caption' => 'Placeholder dokumentasi',
                        'is_main' => ($i === 0 && (abs(crc32($mockId)) % 5) === 0),
                        'gradId' => $gradId,
                        'emoji' => ['📷','📸','🎞','🖼','📅','👥','🏛','📋'][$gradId],
                    ]);
                }
            }
        }

        return $photos;
    }

    /**
     * Get gallery statistics.
     */
    public function getStatistics($photos, array $filters = [])
    {
        $kegiatanQuery = Kegiatan::query();
        if (!empty($filters['unit_id'])) {
            $kegiatanQuery->where('unit_id', $filters['unit_id']);
        }

        return [
            'total_foto' => $photos->count(),
            'total_kegiatan' => $kegiatanQuery->count(),
            'total_size' => $photos->sum('size'),
            'upload_bulan_ini' => $photos->filter(fn($p) => isset($p->bulan) && $p->bulan == now()->format('m'))->count(),
        ];
    }

    /**
     * Get media items for ZIP.
     */
    public function getMediaForZip(array $ids = [], array $filters = [])
    {
        $query = Kegiatan::with(['unitKerja', 'media']);

        // Apply filters if provided
        if (!empty($filters)) {
            if (!empty($filters['kegiatan_id'])) {
                $query->where('id', $filters['kegiatan_id']);
            }
            if (!empty($filters['unit_id'])) {
                $query->where('unit_id', $filters['unit_id']);
            }
            if (!empty($filters['unit'])) {
                $query->whereHas('unitKerja', function($q) use ($filters) {
                    $q->where('nama_instansi', $filters['unit']);
                });
            }
            if (!empty($filters['search'])) {
                $query->where('judul', 'like', '%' . $filters['search'] . '%');
            }
        }

        $kegiatans = $query->get();
        $results = [];

        foreach ($kegiatans as $kegiatan) {
            $mediaItems = $kegiatan->getMedia('foto_kegiatan');
            
            // If specific IDs are provided, filter mediaItems
            if (!empty($ids)) {
                $mediaItems = $mediaItems->filter(function($m) use ($ids) {
                    return in_array('media_' . $m->id, $ids);
                });
            }

            if ($mediaItems->isNotEmpty()) {
                $results[] = [
                    'kegiatan' => $kegiatan->judul,
                    'media' => $mediaItems
                ];
            }
        }

        return $results;
    }

    /**
     * Delete media items.
     */
    public function deleteMedia(array $ids)
    {
        // Only process real media IDs (prefixed with media_)
        $realIds = collect($ids)
            ->filter(fn($id) => str_starts_with($id, 'media_'))
            ->map(fn($id) => str_replace('media_', '', $id))
            ->toArray();

        if (empty($realIds)) {
            return true; // No real media to delete (e.g. only mock data)
        }

        return \Spatie\MediaLibrary\MediaCollections\Models\Media::whereIn('id', $realIds)->delete();
    }

    /**
     * Upload media items.
     */
    public function uploadMedia(string $kegiatanId, array $files, string $caption = null)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatanId);
        $newMedia = [];

        foreach ($files as $file) {
            $media = $kegiatan->addMedia($file)
                ->withCustomProperties(['caption' => $caption ?? $kegiatan->judul])
                ->toMediaCollection('foto_kegiatan');
            
            $newMedia[] = (object)[
                'id' => 'media_' . $media->id,
                'url' => $media->getUrl(),
                'thumb' => $media->getUrl(),
                'kegiatan' => $kegiatan->judul,
                'kegiatanId' => $kegiatan->id,
                'unit' => $kegiatan->unitKerja->nama_instansi ?? 'Umum',
                'tanggal' => $kegiatan->tanggal ? $kegiatan->tanggal->format('d M Y') : '-',
                'bulan' => $kegiatan->tanggal ? $kegiatan->tanggal->format('m') : null,
                'size' => round((abs(crc32($media->id)) % 4000 + 500) / 1024, 1), // Consistent size based on ID
                'caption' => $caption ?? $kegiatan->judul,
                'is_main' => false,
                'gradId' => (abs(crc32($media->id)) % 8),
                'emoji' => ['📷','📸','🎞','🖼','📅','👥','🏛','📋'][(abs(crc32($media->id)) % 8)],
            ];
        }

        return $newMedia;
    }
}
