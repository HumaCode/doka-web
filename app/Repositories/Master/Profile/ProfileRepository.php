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
        return User::with([
            'unitKerja',
            'kegiatans' => function($q) {
                $q->withCount('media');
            }
        ])->findOrFail($id);
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

    public function getActivities(string $userId, int $perPage = 10)
    {
        return \Spatie\Activitylog\Models\Activity::where('causer_id', $userId)
            ->where('causer_type', User::class)
            ->latest()
            ->paginate($perPage);
    }
}
