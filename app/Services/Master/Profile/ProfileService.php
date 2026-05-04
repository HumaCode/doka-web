<?php

namespace App\Services\Master\Profile;

use App\Repositories\Master\Profile\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService implements ProfileServiceInterface
{
    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * Get profile data for the current user.
     *
     * @return array
     */
    public function getProfileData()
    {
        $user = $this->profileRepository->findById(Auth::id());
        
        return [
            'user' => $user,
            // Add other relevant data if needed (e.g. activity stats)
            'stats' => [
                'total_kegiatan' => $user->kegiatans()->count(),
                'total_foto' => $user->media()->count(),
            ]
        ];
    }

    /**
     * Update user profile.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function updateProfile(array $data)
    {
        return $this->profileRepository->update(Auth::id(), $data);
    }

    /**
     * Update user password.
     *
     * @param array $data
     * @return bool
     */
    public function updatePassword(array $data)
    {
        $user = Auth::user();

        if (!Hash::check($data['current_password'], $user->password)) {
            throw new \Exception('Password saat ini tidak sesuai.');
        }

        $user->update([
            'password' => Hash::make($data['new_password'])
        ]);

        return true;
    }

    /**
     * Update user avatar.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function updateAvatar($file)
    {
        $user = Auth::user();
        $media = $user->addMedia($file)->toMediaCollection('avatar');
        return $media->getUrl();
    }

    /**
     * Update user cover.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function updateCover($file)
    {
        $user = Auth::user();
        $media = $user->addMedia($file)->toMediaCollection('cover');
        return $media->getUrl();
    }
}
