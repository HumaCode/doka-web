<?php

namespace App\Policies;

use App\Models\Laporan\ExportHistory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExportHistoryPolicy
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
        return true; // Everyone can see their own history (filtered in controller)
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExportHistory $exportHistory): bool
    {
        return $user->id === $exportHistory->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExportHistory $exportHistory): bool
    {
        return $user->id === $exportHistory->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ExportHistory $exportHistory): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ExportHistory $exportHistory): bool
    {
        return false;
    }
}
