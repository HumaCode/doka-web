<?php

namespace App\Services\Master\Kategori;

use App\Repositories\Master\Kategori\CategoryRepositoryInterface;
use App\Http\Resources\Master\CategoryResource;
use App\Http\Resources\PaginateResource;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories(int $perPage = 10, array $filters = []): array
    {
        $categories = $this->categoryRepository->getAllPagination($perPage, $filters);
        $stats = $this->categoryRepository->getStats();

        $resource = PaginateResource::make($categories, CategoryResource::class)->toArray(request());
        $resource['stats'] = $stats;

        return $resource;
    }

    public function getCategoryById(string $id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(string $id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory(string $id)
    {
        return $this->categoryRepository->delete($id);
    }

    public function toggleCategoryStatus(string $id)
    {
        $category = $this->categoryRepository->findById($id);
        $newStatus = $category->status === 'active' ? 'inactive' : 'active';
        
        return $this->categoryRepository->update($id, ['status' => $newStatus]);
    }
}
