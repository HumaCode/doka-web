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

        $resource = PaginateResource::make($unitKerjas, UnitKerjaResource::class)->toArray(request());
        $resource['stats'] = $stats;

        return $this->success(null, $resource);
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

    /**
     * Toggle status of the specified unit kerja via AJAX.
     */
    public function toggleStatus($id)
    {
        try {
            $unitKerja = $this->unitKerjaService->toggleUnitKerjaStatus($id);
            if (!$unitKerja) return $this->error('Unit Kerja tidak ditemukan.', 404);

            $status = $unitKerja->status === 'active' ? 'diaktifkan' : 'dinonaktifkan';
            return $this->success("Unit Kerja berhasil {$status}.");
        } catch (\Exception $e) {
            return $this->error('Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified unit kerja via AJAX.
     */
    public function destroy($id)
    {
        try {
            $unitKerja = $this->unitKerjaService->getUnitKerjaById($id);
            if (!$unitKerja) return $this->error('Unit Kerja tidak ditemukan.', 404);

            // Cek apakah sedang digunakan oleh user melalui users_count yang sudah di-load di repository findById
            if ($unitKerja->users_count > 0) {
                return $this->error("Unit Kerja tidak dapat dihapus karena sedang digunakan oleh {$unitKerja->users_count} pengguna.", 422);
            }

            $this->unitKerjaService->deleteUnitKerja($id);
            return $this->success('Unit Kerja berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status for multiple unit kerja records.
     */
    public function bulkToggleStatus(Request $request)
    {
        try {
            $ids = $request->get('ids');
            if (empty($ids)) return $this->error('Tidak ada data terpilih.', 400);

            $this->unitKerjaService->bulkToggleStatus($ids);
            return $this->success('Status unit kerja terpilih berhasil diubah.');
        } catch (\Exception $e) {
            return $this->error('Gagal mengubah status massal: ' . $e->getMessage());
        }
    }

    /**
     * Remove multiple unit kerja records via AJAX.
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->get('ids');
            if (empty($ids)) return $this->error('Tidak ada data terpilih.', 400);

            $result = $this->unitKerjaService->deleteBulkUnitKerjas($ids);
            
            $deleted = $result['deleted_count'];
            $skipped = $result['skipped_count'];

            if ($deleted > 0 && $skipped > 0) {
                return $this->success("{$deleted} Unit Kerja berhasil dihapus. {$skipped} dilewati karena sedang digunakan oleh pengguna.");
            } elseif ($deleted > 0) {
                return $this->success("{$deleted} Unit Kerja berhasil dihapus.");
            } else {
                return $this->error("Tidak ada data yang dihapus. {$skipped} unit kerja sedang digunakan oleh pengguna.", 422);
            }
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus data massal: ' . $e->getMessage());
        }
    }
}
