<?php

namespace App\Repositories\Master\Pengguna;

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

    /**
     * Create a new user.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function create(array $data);

    /**
     * Find a user by ID.
     *
     * @param string|int $id
     * @return \App\Models\User|null
     */
    public function findById($id);

    /**
     * Update an existing user.
     *
     * @param string|int $id
     * @param array $data
     * @return \App\Models\User
     */
    public function update($id, array $data);

    /**
     * Delete an existing user.
     *
     * @param string|int $id
     * @return bool
     */
    public function delete($id);

    /**
     * Get users by an array of IDs.
     *
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByIds(array $ids);

    /**
     * Delete multiple users.
     *
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * Toggle active status of a user.
     *
     * @param string $id
     * @return \App\Models\User
     */
    public function toggleStatus(string $id);
}
