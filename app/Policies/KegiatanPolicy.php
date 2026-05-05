<?php

namespace App\Policies;

use App\Models\Kegiatan\Kegiatan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KegiatanPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('dev') || $user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('kegiatan.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Kegiatan $kegiatan): bool
    {
        return $user->can('kegiatan.view') && $user->unit_kerja_id === $kegiatan->unit_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('kegiatan.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Kegiatan $kegiatan): bool
    {
        return $user->can('kegiatan.edit') && $user->unit_kerja_id === $kegiatan->unit_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Kegiatan $kegiatan): bool
    {
        return $user->can('kegiatan.delete') && $user->unit_kerja_id === $kegiatan->unit_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Kegiatan $kegiatan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Kegiatan $kegiatan): bool
    {
        return false;
    }
}
