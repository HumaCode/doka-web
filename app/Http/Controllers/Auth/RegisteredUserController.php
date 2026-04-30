<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Master\UnitKerja;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $unitKerjas = UnitKerja::where('status', 'active')->orderBy('nama_instansi')->get();
        $verifiedEmail = session('register_email');
        return view('auth.register', compact('unitKerjas', 'verifiedEmail'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        if (!\App\Helpers\ReCaptchaHelper::verify($request->g_recaptcha_response)) {
            return response()->json([
                'success' => false,
                'message' => 'Terdeteksi aktivitas mencurigakan (reCAPTCHA gagal).',
            ], 403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'min:4', 'max:20', 'unique:'.User::class, 'regex:/^[a-z0-9_]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'unit_kerja_id' => ['required', 'exists:unit_kerja,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'unit_kerja_id' => $request->unit_kerja_id,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        // Assign default role
        $user->assignRole('user');

        // Handle Avatar using Spatie Media Library
        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')
                ->toMediaCollection('avatars');
        }

        event(new Registered($user));

        Auth::login($user);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Menyiapkan dashboard...',
                'redirect' => route('dashboard')
            ]);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
