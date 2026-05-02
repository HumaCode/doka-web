<?php

namespace App\Http\Resources\Kegiatan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KegiatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'tanggal' => $this->tanggal->format('d M Y'),
            'tanggal_raw' => $this->tanggal->format('Y-m-d'),
            'waktu' => $this->waktu ? \Carbon\Carbon::parse($this->waktu)->format('H:i') : null,
            'lokasi' => $this->lokasi,
            'uraian' => $this->uraian,
            'short_uraian' => str($this->uraian)->stripTags()->limit(100),
            'jumlah_peserta' => $this->jumlah_peserta ?? 0,
            'narasumber' => $this->narasumber,
            'status' => $this->status,
            'tags' => $this->tags,
            
            // Relationships
            'kategori' => [
                'id' => $this->kategori?->id,
                'nama' => $this->kategori?->nama_kategori ?? 'Tanpa Kategori',
                'warna' => $this->kategori?->warna ?? '#64748b',
                'icon' => $this->kategori?->icon ?? 'bi-tag',
            ],
            'unit' => [
                'id' => $this->unitKerja?->id,
                'nama' => $this->unitKerja?->nama_instansi ?? 'Semua Unit',
                'singkatan' => $this->unitKerja?->singkatan ?? '-',
            ],
            'petugas' => [
                'id' => $this->petugas?->id,
                'name' => $this->petugas?->name ?? 'System',
                'avatar' => $this->petugas?->getFirstMediaUrl('avatar') ?: null,
                'initials' => $this->petugas ? collect(explode(' ', $this->petugas->name))->map(fn($n) => str($n)->substr(0,1))->take(2)->join('') : 'SY',
            ],

            // Media
            'foto' => $this->getMedia('foto_kegiatan')->map(fn($media) => [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'thumb' => $media->getUrl(), 
            ]),
            'attachments' => $this->getMedia('lampiran_kegiatan')->map(fn($media) => [
                'id' => $media->id,
                'uuid' => $media->uuid,
                'file_name' => $media->file_name,
                'size' => $media->human_readable_size,
                'mime' => $media->mime_type,
                'download_url' => route('kegiatan.download', $media->uuid),
            ]),
            'cover' => $this->getFirstMediaUrl('foto_kegiatan') ?: asset('assets/img/placeholder-kegiatan.jpg'),
            'foto_count' => $this->getMedia('foto_kegiatan')->count(),
            'attachment_count' => $this->getMedia('lampiran_kegiatan')->count(),
        ];
    }
}
