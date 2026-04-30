<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\Master\UnitKerjaResource;
use App\Services\Master\UnitKerja\UnitKerjaServiceInterface;
use App\Http\Requests\Master\UnitKerja\StoreUnitKerjaRequest;
use App\Http\Requests\Master\UnitKerja\UpdateUnitKerjaRequest;
use App\Models\Master\UnitKerja;
use App\Models\User;

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
        $rawStats = UnitKerja::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active
        ")->first();

        $totalUsers = User::count();

        $stats = [
            'total'    => (int) $rawStats->total,
            'active'   => (int) $rawStats->active,
            'kegiatan' => 0,
            'pengguna' => $totalUsers,
        ];

        return $this->success(null, PaginateResource::make($unitKerjas, UnitKerjaResource::class)->additional([
            'stats' => $stats
        ]));
    }

    /**
     * Store a newly created unit kerja via AJAX.
     */
    public function store(StoreUnitKerjaRequest $request)
    {
        try {
            $data = $request->validated();
            $this->unitKerjaService->createUnitKerja($data);

            return $this->success('Unit Kerja berhasil ditambahkan.');
        } catch (\Exception $e) {
            return $this->error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified unit kerja for editing.
     */
    public function show($id)
    {
        try {
            $unitKerja = $this->unitKerjaService->getUnitKerjaById($id);
            if (!$unitKerja) return $this->error('Unit Kerja tidak ditemukan.', 404);

            return $this->success('Data berhasil dimuat.', new UnitKerjaResource($unitKerja));
        } catch (\Exception $e) {
            return $this->error('Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified unit kerja via AJAX.
     */
    public function update(UpdateUnitKerjaRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->unitKerjaService->updateUnitKerja($id, $data);

            return $this->success('Unit Kerja berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->error('Gagal memperbarui data: ' . $e->getMessage());
        }
    }
}
