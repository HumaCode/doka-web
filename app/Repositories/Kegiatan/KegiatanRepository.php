<?php

namespace App\Repositories\Kegiatan;

use App\Models\Kegiatan\Kegiatan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class KegiatanRepository implements KegiatanRepositoryInterface
{
    /**
     * Get all activities with pagination and filtering.
     */
    public function getAllPagination(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = Kegiatan::with(['kategori', 'unitKerja', 'petugas', 'media']);

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('judul', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('uraian', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['kategori'])) {
            $query->where('kategori_id', $filters['kategori']);
        }

        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortField, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Create a new activity.
     */
    public function create(array $data)
    {
        return Kegiatan::create($data);
    }

    /**
     * Find an activity by ID.
     */
    public function findById($id)
    {
        return Kegiatan::with(['kategori', 'unitKerja', 'petugas', 'media'])->findOrFail($id);
    }

    /**
     * Update an existing activity.
     */
    public function update($id, array $data)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update($data);
        return $kegiatan;
    }

    /**
     * Delete an activity.
     */
    public function delete($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return $kegiatan->delete();
    }

    /**
     * Get activities by multiple IDs.
     */
    public function getByIds(array $ids)
    {
        return Kegiatan::whereIn('id', $ids)->get();
    }

    /**
     * Delete multiple activities.
     */
    public function deleteBulk(array $ids)
    {
        return Kegiatan::whereIn('id', $ids)->get()->each->delete();
    }

    /**
     * Get related activities.
     */
    public function getRelated($id, int $limit = 6)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return Kegiatan::with(['kategori', 'media'])
            ->where('kategori_id', $kegiatan->kategori_id)
            ->where('id', '!=', $id)
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Get global statistics.
     */
    public function getStats()
    {
        return Cache::remember('kegiatan_stats_global', 3600, function () {
            return [
                'total' => Kegiatan::count(),
                'selesai' => Kegiatan::where('status', 'selesai')->count(),
                'draft' => Kegiatan::where('status', 'draft')->count(),
                'berjalan' => Kegiatan::where('status', 'berjalan')->count(),
            ];
        });
    }
}
