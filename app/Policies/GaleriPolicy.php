<?php

namespace App\Policies;

use App\Models\User;

use App\Models\Kegiatan\Kegiatan;

class GaleriPolicy
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
     * Determine whether the user can view the gallery.
     */
    public function view(User $user): bool
    {
        return $user->can('foto.view');
    }

    /**
     * Determine whether the user can upload photos to a specific activity.
     */
    public function upload(User $user, Kegiatan $kegiatan): bool
    {
        // Uploading to gallery is essentially editing the activity
        return $user->can('kegiatan.edit') && $user->unit_kerja_id === $kegiatan->unit_id;
    }

    /**
     * Determine whether the user can delete photos from a specific activity.
     */
    public function delete(User $user, Kegiatan $kegiatan): bool
    {
        return $user->can('foto.delete') && $user->unit_kerja_id === $kegiatan->unit_id;
    }
}
