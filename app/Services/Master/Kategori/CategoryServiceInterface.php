<?php

namespace App\Services\Master\Kategori;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryServiceInterface
{
    public function getCategories(int $perPage = 10, array $filters = []): array;
    public function getCategoryById(string $id);
    public function createCategory(array $data);
    public function updateCategory(string $id, array $data);
    public function deleteCategory(string $id);
    public function toggleCategoryStatus(string $id);
}
