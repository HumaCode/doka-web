<?php

namespace App\Services\Kegiatan;

use App\Repositories\Kegiatan\KegiatanRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class KegiatanService implements KegiatanServiceInterface
{
    protected $kegiatanRepository;

    public function __construct(KegiatanRepositoryInterface $kegiatanRepository)
    {
        $this->kegiatanRepository = $kegiatanRepository;
    }

    public function getActivities(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        return $this->kegiatanRepository->getAllPagination($perPage, $filters);
    }

    public function createActivity(array $data, array $files = [])
    {
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }
        $kegiatan = $this->kegiatanRepository->create($data);

        // Handle Photos
        if (!empty($files['photos'])) {
            foreach ($files['photos'] as $photo) {
                $kegiatan->addMedia($photo)->toMediaCollection('foto_kegiatan');
            }
        }

        // Handle Attachments
        if (!empty($files['attachments'])) {
            foreach ($files['attachments'] as $file) {
                $kegiatan->addMedia($file)->toMediaCollection('lampiran_kegiatan');
            }
        }

        Cache::forget('kegiatan_stats_global');

        return $kegiatan;
    }

    public function getActivityById($id)
    {
        return $this->kegiatanRepository->findById($id);
    }

    public function updateActivity($id, array $data, array $files = [], array $deletedMedia = [])
    {
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }
        $kegiatan = $this->kegiatanRepository->update($id, $data);

        // Handle Media Deletion
        if (!empty($deletedMedia)) {
            Media::whereIn('id', $deletedMedia)
                ->where('model_id', $kegiatan->id)
                ->get()
                ->each
                ->delete();
        }

        // Handle New Photos
        if (!empty($files['photos'])) {
            foreach ($files['photos'] as $photo) {
                $kegiatan->addMedia($photo)->toMediaCollection('foto_kegiatan');
            }
        }

        // Handle New Attachments
        if (!empty($files['attachments'])) {
            foreach ($files['attachments'] as $file) {
                $kegiatan->addMedia($file)->toMediaCollection('lampiran_kegiatan');
            }
        }

        Cache::forget('kegiatan_stats_global');

        return $kegiatan;
    }

    public function deleteActivity($id)
    {
        Cache::forget('kegiatan_stats_global');
        return $this->kegiatanRepository->delete($id);
    }

    public function deleteBulkActivities(array $ids)
    {
        Cache::forget('kegiatan_stats_global');
        return $this->kegiatanRepository->deleteBulk($ids);
    }

    public function getRelatedActivities($id, int $limit = 6)
    {
        return $this->kegiatanRepository->getRelated($id, $limit);
    }

    public function getDashboardStats(array $filters = [])
    {
        return $this->kegiatanRepository->getStats($filters);
    }
}
