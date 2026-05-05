<?php

namespace App\Services\Dashboard;

use App\Models\Kegiatan\Kegiatan;
use App\Models\User;
use App\Models\Master\UnitKerja;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class DashboardService implements DashboardServiceInterface
{
    /**
     * Get statistics for Admin Dashboard with short-term caching.
     */
    public function getAdminStats()
    {
        return Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'total_kegiatan' => Kegiatan::count(),
                'total_foto'     => DB::table('media')->where('collection_name', 'foto_kegiatan')->count(),
                'total_user'     => User::where('is_active', true)->count(),
                'kegiatan_month' => Kegiatan::whereMonth('tanggal', now()->month)
                                    ->whereYear('tanggal', now()->year)->count(),
            ];
        });
    }

    /**
     * Get data for Landing Page with longer caching.
     */
    public function getFrontendStats()
    {
        return Cache::remember('frontend_stats', 600, function () {
            return [
                'total_unit'     => UnitKerja::count(),
                'total_kegiatan' => Kegiatan::count(),
                'total_foto'     => DB::table('media')->count(),
                'total_user'     => User::count(),
            ];
        });
    }

    /**
     * Global search logic with eager loading to prevent N+1.
     */
    public function searchAll($query, $user)
    {
        $results = [
            'kegiatans'  => collect(),
            'users'      => collect(),
            'unitKerjas' => collect()
        ];

        if ($user->can('kegiatan.view')) {
            $results['kegiatans'] = Kegiatan::with(['unitKerja', 'media'])
                ->where('judul', 'like', "%$query%")
                ->orWhere('deskripsi', 'like', "%$query%")
                ->latest()
                ->limit(10)
                ->get();
        }

        if ($user->can('user.view')) {
            $results['users'] = User::with(['unitKerja'])
                ->where('name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->limit(10)
                ->get();
        }

        if ($user->can('unitkerja.manage')) {
            $results['unitKerjas'] = UnitKerja::where('nama_instansi', 'like', "%$query%")
                ->limit(5)
                ->get();
        }

        return $results;
    }
}
