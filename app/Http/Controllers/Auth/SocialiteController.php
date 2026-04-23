<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find existing user by google_id or email
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Update user if found by email but no google_id
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                }
            } else {
                // Create new user (Register)
                $user = User::create([
                    'id' => (string) Str::ulid(),
                    'name' => $googleUser->name,
                    'username' => $this->generateUsername($googleUser->name),
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => Hash::make(Str::random(16)), // Random password
                    'email_verified_at' => Carbon::now(),
                    'is_active' => '1',
                ]);

                // Assign default role
                $user->assignRole('user');
            }

            // Sync tokens
            $user->update([
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);

            Auth::login($user);

            return redirect()->intended(route('dashboard', absolute: false));
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal masuk menggunakan Google. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Generate a unique username from name.
     */
    private function generateUsername($name)
    {
        $base = Str::slug($name, '');
        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $counter;
            $counter++;
        }

        return $username;
    }
}
