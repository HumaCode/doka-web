<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan\Kegiatan;
use App\Models\User;
use App\Models\Master\UnitKerja;
use App\Services\Dashboard\DashboardServiceInterface;
use App\Services\Master\SystemSetting\SystemSettingServiceInterface;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $dashboardService;
    protected $settingService;

    public function __construct(
        DashboardServiceInterface $dashboardService,
        SystemSettingServiceInterface $settingService
    ) {
        $this->dashboardService = $dashboardService;
        $this->settingService = $settingService;
    }

    public function index()
    {
        $stats = $this->dashboardService->getAdminStats();
        
        $recent_activities = Activity::with('causer')->latest()->limit(5)->get();
                            
        // Optimized Chart data
        $chart_data = Kegiatan::select('kategori_id', DB::raw('count(*) as total'))
                    ->groupBy('kategori_id')
                    ->with('kategori:id,nama_kategori') // Only fetch needed columns
                    ->get();
                    
        // Calendar Data (Limited for current month)
        $monthly_kegiatans = Kegiatan::select('id', 'judul', 'tanggal')
                            ->whereMonth('tanggal', now()->month)
                            ->whereYear('tanggal', now()->year)
                            ->get();
                            
        // Optimized Data for Quick Actions (Reduce memory footprint)
        $kegiatans = Kegiatan::select('id', 'judul')->latest()->limit(20)->get();
        $unitKerjas = UnitKerja::select('id', 'nama_instansi')->where('status', 'active')->get();
        $roles = Role::select('id', 'name')->get();

        return view('pages.dashboard.dashboard-dev', compact(
            'stats', 
            'recent_activities', 
            'chart_data', 
            'monthly_kegiatans',
            'kegiatans',
            'unitKerjas',
            'roles'
        ));
    }

    public function search(Request $request)
    {
        $q = $request->query('q');
        if (!$q) return redirect()->route('dashboard');

        $user = auth()->user();
        $results = $this->dashboardService->searchAll($q, $user);

        return view('pages.search.index', array_merge($results, ['q' => $q]));
    }

    public function apiSearch(Request $request)
    {
        $q = $request->query('q');
        if (!$q) return response()->json([]);
        
        $user = auth()->user();
        if (!$user->can('kegiatan.view')) {
            return response()->json([]);
        }

        // Use same service logic but for API suggestion
        $results = $this->dashboardService->searchAll($q, $user);

        return response()->json($results['kegiatans']);
    }

    /**
     * Display the frontend landing page.
     */
    public function frontend()
    {
        $stats = $this->dashboardService->getFrontendStats();
        $settings = $this->settingService->getSettings();

        return view('frontend.index', compact('stats', 'settings'));
    }
}
