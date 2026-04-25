<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Get all users with pagination.
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllPagination(int $perPage = 10, array $filters = []): LengthAwarePaginator;
}
