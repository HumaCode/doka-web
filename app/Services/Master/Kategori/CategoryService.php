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
        
        // Cache stats for 5 minutes
        $stats = cache()->remember('category_stats_global', 300, function() {
            return $this->categoryRepository->getStats();
        });

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
        $result = $this->categoryRepository->create($data);
        cache()->forget('category_stats_global');
        return $result;
    }

    public function updateCategory(string $id, array $data)
    {
        $result = $this->categoryRepository->update($id, $data);
        cache()->forget('category_stats_global');
        return $result;
    }

    public function deleteCategory(string $id)
    {
        $result = $this->categoryRepository->delete($id);
        cache()->forget('category_stats_global');
        return $result;
    }

    public function toggleCategoryStatus(string $id)
    {
        $category = $this->categoryRepository->findById($id);
        $newStatus = $category->status === 'active' ? 'inactive' : 'active';
        
        $result = $this->categoryRepository->update($id, ['status' => $newStatus]);
        cache()->forget('category_stats_global');
        return $result;
    }
}
