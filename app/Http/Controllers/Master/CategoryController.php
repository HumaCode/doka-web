<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\CategoryResource;
use App\Http\Resources\PaginateResource;
use App\Models\Master\Kategori;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.kategori.index');
    }

    /**
     * Get all categories with pagination for AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPagination(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $perPage = $request->get('per_page', 12);

        $query = Kategori::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $categories = $query->latest()->paginate($perPage);

        // Stats for mini stats
        $rawStats = Kategori::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive
        ")->first();

        $stats = [
            'total'    => (int) $rawStats->total,
            'active'   => (int) $rawStats->active,
            'inactive' => (int) $rawStats->inactive,
            'kegiatan' => 0, // Placeholder
            'foto'     => 0, // Placeholder
        ];

        $resource = PaginateResource::make($categories, CategoryResource::class)->toArray($request);
        $resource['stats'] = $stats;

        return $this->success(null, $resource);
    }

    /**
     * Store a newly created category via AJAX.
     *
     * @param \App\Http\Requests\Master\Kategori\StoreKategoriRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\App\Http\Requests\Master\Kategori\StoreKategoriRequest $request)
    {
        try {
            $data = $request->validated();
            Kategori::create($data);

            return $this->success('Kategori baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return $this->error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified category.
     *
     * @param Kategori $kategori
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Kategori $kategori)
    {
        return $this->success(null, CategoryResource::make($kategori));
    }

    /**
     * Update the specified category via AJAX.
     *
     * @param \App\Http\Requests\Master\Kategori\UpdateKategoriRequest $request
     * @param Kategori $kategori
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\App\Http\Requests\Master\Kategori\UpdateKategoriRequest $request, Kategori $kategori)
    {
        try {
            $data = $request->validated();
            $kategori->update($data);

            return $this->success('Data kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status of the specified category.
     *
     * @param Kategori $kategori
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Kategori $kategori)
    {
        try {
            $newStatus = $kategori->status === 'active' ? 'inactive' : 'active';
            $kategori->update(['status' => $newStatus]);

            $statusText = $newStatus === 'active' ? 'Aktif' : 'Nonaktif';
            return $this->success("Status kategori berhasil diubah menjadi {$statusText}.");
        } catch (\Exception $e) {
            return $this->error('Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Kategori $kategori
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Kategori $kategori)
    {
        try {
            $kategori->delete();
            return $this->success('Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}
