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
        $kegiatans = $user->kegiatans;
        
        // Calculate Consistency (Days active in last 30 days)
        $activeDays = \Spatie\Activitylog\Models\Activity::where('causer_id', $user->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->distinct()
            ->selectRaw('DATE(created_at)')
            ->count();
        $consistency = min(100, round(($activeDays / 20) * 100)); // 20 days/month = 100%

        // Calculate Completeness (Avg completeness of fields in kegiatan)
        $totalCompleteness = 0;
        if ($kegiatans->count() > 0) {
            foreach ($kegiatans as $k) {
                $score = 0;
                if (!empty($k->judul)) $score += 20;
                if (!empty($k->uraian)) $score += 20;
                if (!empty($k->lokasi)) $score += 20;
                if (!empty($k->tags)) $score += 20;
                if ($k->media_count > 0) $score += 20;
                $totalCompleteness += $score;
            }
            $completeness = round($totalCompleteness / $kegiatans->count());
        } else {
            $completeness = 0;
        }

        return [
            'user' => $user,
            'stats' => [
                'total_kegiatan' => $kegiatans->count(),
                'total_foto' => $user->media()->count(),
                'consistency' => $consistency,
                'completeness' => $completeness
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

    public function getActivities(int $perPage = 10)
    {
        return $this->profileRepository->getActivities(Auth::id(), $perPage);
    }
}
