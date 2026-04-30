<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ReCaptchaHelper
{
    /**
     * Verify reCAPTCHA v3 token with Google API.
     *
     * @param string|null $token
     * @return bool
     */
    public static function verify($token)
    {
        if (!$token) {
            return false;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            // Success if 'success' is true and score is at least 0.5
            return $result['success'] && ($result['score'] >= 0.5);
        } catch (\Exception $e) {
            return false;
        }
    }
}
