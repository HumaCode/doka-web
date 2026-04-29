<?php

namespace App\Repositories\Master\Kategori;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getAllPagination(int $perPage, array $filters): LengthAwarePaginator;
    public function findById(string $id);
    public function create(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
    public function getStats(): array;
}
