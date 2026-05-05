<?php

namespace App\Repositories\Master\Profile;

use App\Models\User;

interface ProfileRepositoryInterface
{
    /**
     * Get user profile by ID.
     *
     * @param string $id
     * @return User
     */
    public function findById(string $id);

    /**
     * Update user profile.
     *
     * @param string $id
     * @param array $data
     * @return User
     */
    public function update(string $id, array $data);

    /**
     * Get paginated activities for a user.
     *
     * @param string $userId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getActivities(string $userId, int $perPage = 10);
}
