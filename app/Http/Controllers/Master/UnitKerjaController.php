<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\Master\UnitKerjaResource;
use App\Services\Master\UnitKerja\UnitKerjaServiceInterface;

class UnitKerjaController extends Controller
{
    protected $unitKerjaService;

    public function __construct(UnitKerjaServiceInterface $unitKerjaService)
    {
        $this->unitKerjaService = $unitKerjaService;
    }

    public function index()
    {
        return view('pages.unit-kerja.index');
    }

    /**
     * Get all unit kerja with pagination for AJAX.
     */
    public function getAllPagination(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'jenis'  => $request->get('jenis'),
        ];

        $perPage = $request->get('per_page', 15);

        $unitKerjas = $this->unitKerjaService->getUnitKerjas($perPage, $filters);

        // Stats calculation
        $rawStats = \App\Models\Master\UnitKerja::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active
        ")->first();

        // Optional: Count total users and activities if needed
        $totalUsers = \App\Models\User::count();

        $stats = [
            'total'    => (int) $rawStats->total,
            'active'   => (int) $rawStats->active,
            'kegiatan' => 0, // Placeholder
            'pengguna' => $totalUsers,
        ];

        return $this->success(null, PaginateResource::make($unitKerjas, UnitKerjaResource::class)->additional([
            'stats' => $stats
        ]));
    }
}
