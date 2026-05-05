<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Profile\UpdateProfileRequest;
use App\Services\Master\Profile\ProfileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileServiceInterface $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display the profile page.
     */
    public function index()
    {
        $data = $this->profileService->getProfileData();
        return view('pages.profile.index', $data);
    }

    /**
     * Update user profile.
     */
    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = $this->profileService->updateProfile($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui.',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $this->profileService->updatePassword($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update user avatar.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        try {
            $url = $this->profileService->updateAvatar($request->file('avatar'));
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui.',
                'url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui foto profil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user cover.
     */
    public function updateCover(Request $request)
    {
        $request->validate([
            'cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        try {
            $url = $this->profileService->updateCover($request->file('cover'));
            return response()->json([
                'success' => true,
                'message' => 'Cover berhasil diperbarui.',
                'url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui cover: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user activities.
     */
    public function getActivities(Request $request)
    {
        $activities = $this->profileService->getActivities(10);
        return response()->json($activities);
    }
}
