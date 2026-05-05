<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Laporan\LaporanServiceInterface;
use App\Models\Master\Kategori;
use App\Models\Master\UnitKerja;

class LaporanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanServiceInterface $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    /**
     * Display the monthly report index page.
     */
    public function bulanan(Request $request)
    {
        $filters = $request->only(['bulan', 'tahun', 'unit_id', 'kategori_id']);
        
        // Apply unit work filter for admin (Dev can see everything)
        if (auth()->user()->hasRole('admin') && !auth()->user()->hasRole('dev')) {
            $filters['unit_id'] = auth()->user()->unit_kerja_id;
        }

        $reportData = $this->laporanService->getMonthlyReportData($filters);

        if ($request->ajax()) {
            return response()->json($reportData);
        }
        
        $categories = Kategori::select(['id', 'nama_kategori'])->orderBy('nama_kategori')->get();
        $units = UnitKerja::select(['id', 'nama_instansi'])->orderBy('nama_instansi')->get();

        return view('pages.laporan.bulanan', compact('reportData', 'categories', 'units'));
    }
}
