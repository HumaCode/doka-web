<?php

namespace App\Services\Master\Profile;

interface ProfileServiceInterface
{
    /**
     * Get profile data for the current user.
     *
     * @return array
     */
    public function getProfileData();

    /**
     * Update user profile.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function updateProfile(array $data);

    /**
     * Update user password.
     *
     * @param array $data
     * @return bool
     */
    public function updatePassword(array $data);

    /**
     * Update user avatar.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function updateAvatar($file);

    /**
     * Update user cover.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function updateCover($file);
    public function getActivities(int $perPage = 10);
}
