<?php

namespace App\Repositories\Master\Kategori;

use App\Models\Master\Kategori;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllPagination(int $perPage, array $filters): LengthAwarePaginator
    {
        $query = Kategori::query()
            ->withCount('kegiatans')
            ->withCount(['kegiatans as foto_count' => function($q) {
                $q->join('media', 'kegiatans.id', '=', 'media.model_id')
                  ->where('media.model_type', \App\Models\Kegiatan\Kegiatan::class)
                  ->where('media.collection_name', 'foto_kegiatan');
            }]);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->whereFullText(['nama_kategori', 'deskripsi'], $search, ['mode' => 'boolean'])
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function findById(string $id)
    {
        return Kategori::findOrFail($id);
    }

    public function create(array $data)
    {
        return Kategori::create($data);
    }

    public function update(string $id, array $data)
    {
        $category = $this->findById($id);
        $category->update($data);
        return $category;
    }

    public function delete(string $id)
    {
        $category = $this->findById($id);
        return $category->delete();
    }

    public function getStats(): array
    {
        return [
            'total'    => Kategori::count(),
            'active'   => Kategori::where('status', 'active')->count(),
            'kegiatan' => \App\Models\Kegiatan\Kegiatan::count(),
            'foto'     => \Spatie\MediaLibrary\MediaCollections\Models\Media::where('model_type', \App\Models\Kegiatan\Kegiatan::class)
                            ->where('collection_name', 'foto_kegiatan')
                            ->count(),
        ];
    }
}
