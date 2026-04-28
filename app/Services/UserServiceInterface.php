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

    /**
     * Get user by ID.
     *
     * @param string|int $id
     * @return \App\Models\User|null
     */
    public function getUserById($id);

    /**
     * Update an existing user.
     *
     * @param string|int $id
     * @param array $data
     * @param string|int $roleId
     * @return \App\Models\User
     */
    public function updateUser($id, array $data, $roleId);

    /**
     * Delete an existing user.
     *
     * @param string|int $id
     * @return bool
     */
    public function deleteUser($id);
}
