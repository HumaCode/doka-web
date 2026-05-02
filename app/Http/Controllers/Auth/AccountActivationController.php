<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Master\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\NewUserRegistrationNotification;
use App\Models\User;

class AccountActivationController extends Controller
{
    /**
     * Display the pending activation page.
     */
    public function index()
    {
        $user = Auth::user();

        // Check if profile is incomplete
        $isIncomplete = empty($user->unit_kerja_id) ||
            (empty($user->nip) && empty($user->nik)) ||
            empty($user->jabatan);

        // If user is already active AND profile is complete, redirect to dashboard
        if ($user->is_active && !$isIncomplete) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $unitKerjas = UnitKerja::where('status', 'active')
            ->orderBy('nama_instansi')
            ->get();

        return view('auth.pending', compact('unitKerjas'));
    }

    /**
     * Submit activation data.
     */
    public function submit(Request $request): JsonResponse
    {
        $user = Auth::user();

        // Only validate fields that are actually shown/required if missing from DB
        $rules = [
            'keterangan' => 'nullable|string|max:500',
        ];

        if (empty($user->unit_kerja_id)) $rules['unit_kerja_id'] = 'required|exists:unit_kerja,id';
        if (empty($user->nip) && empty($user->nik)) {
            $rules['nip'] = 'nullable|string|size:18';
            $rules['nik'] = 'nullable|string|size:16';
        }
        if (empty($user->jabatan)) $rules['jabatan'] = 'required|string|max:100';
        if (empty($user->phone)) $rules['phone'] = 'nullable|string|max:20';

        $request->validate($rules);

        // Prepare data for update, only taking what's sent or keeping existing
        $updateData = [
            'unit_kerja_id' => $request->unit_kerja_id ?? $user->unit_kerja_id,
            'jabatan'       => $request->jabatan ?? $user->jabatan,
            'phone'         => $request->phone ?? $user->phone,
            'keterangan'    => $request->keterangan,
        ];

        if ($request->has('nip')) $updateData['nip'] = $request->nip;
        if ($request->has('nik')) $updateData['nik'] = $request->nik;

        $user->update($updateData);

        // Send notification to admins
        try {
            $admins = User::role('admin')->get();
            if ($admins->count() > 0) {
                $user->load(['unitKerja', 'roles']);
                Mail::to($admins)->send(new NewUserRegistrationNotification($user));
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email notifikasi admin: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dikirim. Menunggu verifikasi admin.',
        ]);
    }

    /**
     * Quick login for admin from email link.
     */
    public function quickLogin(Request $request, User $user)
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'Link aktivasi tidak valid atau telah kedaluwarsa.');
        }

        // Find the first administrator account
        $admin = User::role('admin')->first();

        if (!$admin) {
            abort(404, 'Tidak ada akun administrator yang tersedia untuk login otomatis.');
        }

        // Auto login as admin
        Auth::login($admin);

        // Redirect to user management with search parameter (using unique ID)
        return redirect()->route('pengguna.index', ['search' => $user->id]);
    }
}
