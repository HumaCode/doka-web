<?php

namespace App\Repositories\Master\Profile;

use App\Models\User;

class ProfileRepository implements ProfileRepositoryInterface
{
    /**
     * Get user profile by ID.
     *
     * @param string $id
     * @return User
     */
    public function findById(string $id)
    {
        return User::with(['unitKerja'])->findOrFail($id);
    }

    /**
     * Update user profile.
     *
     * @param string $id
     * @param array $data
     * @return User
     */
    public function update(string $id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }
}
