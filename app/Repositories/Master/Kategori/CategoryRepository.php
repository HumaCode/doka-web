<?php

namespace App\Repositories\Master\Kategori;

use App\Models\Master\Kategori;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllPagination(int $perPage, array $filters): LengthAwarePaginator
    {
        $query = Kategori::query();

        if (!empty($filters['search'])) {
            $query->where('nama_kategori', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('slug', 'like', '%' . $filters['search'] . '%');
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
            'inactive' => Kategori::where('status', 'inactive')->count(),
        ];
    }
}
