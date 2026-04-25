<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    /**
     * Get users with pagination.
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getUsers(int $perPage = 10, array $filters = []): LengthAwarePaginator;
}
