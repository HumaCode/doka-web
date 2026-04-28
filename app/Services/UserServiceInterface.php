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

    /**
     * Create a new user.
     *
     * @param array $data
     * @param string|int $roleId
     * @return \App\Models\User
     */
    public function createUser(array $data, $roleId);
}
