<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\EmailOtp;
use App\Models\User;
use App\Mail\Auth\OTPMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OTPController extends Controller
{
    /**
     * Send OTP to the provided email.
     */
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // Rate limiting: Check if user already requested OTP in the last 60 seconds
        $recentOtp = EmailOtp::where('email', $email)
            ->where('created_at', '>', Carbon::now()->subSeconds(60))
            ->first();

        if ($recentOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Tunggu sebentar sebelum meminta kode baru.'
            ], 429);
        }

        // Generate 6-digit OTP
        $otpCode = rand(100000, 999999);

        // Delete old OTPs for this email
        EmailOtp::where('email', $email)->delete();

        // Save new OTP
        EmailOtp::create([
            'email' => $email,
            'otp' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(3)
        ]);

        // Send Email
        try {
            Mail::to($email)->send(new OTPMail($otpCode));
            return response()->json([
                'success' => true,
                'message' => 'Kode OTP telah dikirim ke email Anda.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email. Periksa konfigurasi SMTP Anda.'
            ], 500);
        }
    }

    /**
     * Verify the provided OTP.
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric'
        ]);

        $email = $request->email;
        $otpRecord = EmailOtp::where('email', $email)->first();

        if (!$otpRecord) {
            return response()->json(['success' => false, 'message' => 'Kode tidak ditemukan. Silakan minta kode baru.'], 404);
        }

        // Check attempts
        if ($otpRecord->attempts >= 3) {
            $otpRecord->delete();
            return response()->json(['success' => false, 'message' => 'Terlalu banyak percobaan. Silakan minta kode baru.'], 403);
        }

        // Check expiration
        if ($otpRecord->isExpired()) {
            $otpRecord->delete();
            return response()->json(['success' => false, 'message' => 'Kode telah kadaluarsa. Silakan minta kode baru.'], 403);
        }

        // Check OTP match
        if ($otpRecord->otp !== $request->otp) {
            $otpRecord->increment('attempts');
            return response()->json(['success' => false, 'message' => 'Kode OTP salah.'], 422);
        }

        // OTP is valid!
        $otpRecord->delete();

        // Find or prepare user
        $user = User::where('email', $email)->first();

        if ($user) {
            // Existing user: Login
            Auth::login($user);
            return response()->json([
                'success' => true,
                'is_new' => false,
                'redirect' => route('dashboard'),
                'message' => 'Login berhasil!'
            ]);
        } else {
            // New user: Store email in session and redirect to complete profile
            session(['register_email' => $email]);
            return response()->json([
                'success' => true,
                'is_new' => true,
                'redirect' => route('register'), // We'll handle this in register page
                'message' => 'Email terverifikasi. Silakan lengkapi profil Anda.'
            ]);
        }
    }
}
