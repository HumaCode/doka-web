<?php

namespace App\Http\Controllers\Kegiatan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kegiatan\StoreKegiatanRequest;
use App\Http\Requests\Kegiatan\UpdateKegiatanRequest;
use App\Http\Resources\Kegiatan\KegiatanResource;
use App\Http\Resources\PaginateResource;
use App\Services\Kegiatan\KegiatanServiceInterface;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class KegiatanController extends Controller
{
    protected $kegiatanService;

    public function __construct(KegiatanServiceInterface $kegiatanService)
    {
        $this->kegiatanService = $kegiatanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Master\Kategori::where('status', 'active')->get();
        return view('pages.kegiatan.index', compact('categories'));
    }

    /**
     * Get all activities with pagination for AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPagination(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'kategori' => $request->get('kategori'),
            'sort_field' => $request->get('sort_field', 'created_at'),
            'sort_order' => $request->get('sort_order', 'desc'),
        ];

        $perPage = $request->get('per_page', 12);
        $data = $this->kegiatanService->getActivities($perPage, $filters);
        $stats = $this->kegiatanService->getDashboardStats();

        $resource = PaginateResource::make($data, KegiatanResource::class)->toArray(request());
        $resource['stats'] = $stats;

        return $this->success(null, $resource);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Master\Kategori::where('status', 'active')->get();
        $units = \App\Models\Master\UnitKerja::all();
        $users = \App\Models\User::all();

        return view('pages.kegiatan.create', compact('categories', 'units', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKegiatanRequest $request)
    {
        try {
            $files = [
                'photos' => $request->file('photos'),
                'attachments' => $request->file('attachments'),
            ];

            $this->kegiatanService->createActivity($request->validated(), $files);

            return $this->success('Data berhasil disimpan.', [
                'redirect' => route('kegiatan.index')
            ]);
        } catch (\Exception $e) {
            return $this->error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kegiatan = $this->kegiatanService->getActivityById($id);
        $categories = \App\Models\Master\Kategori::where('status', 'active')->get();
        $units = \App\Models\Master\UnitKerja::all();
        $users = \App\Models\User::all();

        return view('pages.kegiatan.edit', compact('kegiatan', 'categories', 'units', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKegiatanRequest $request, $id)
    {
        try {
            $files = [
                'photos' => $request->file('photos'),
                'attachments' => $request->file('attachments'),
            ];

            $deletedMedia = $request->filled('deleted_media') ? explode(',', $request->deleted_media) : [];

            $this->kegiatanService->updateActivity($id, $request->validated(), $files, $deletedMedia);

            return $this->success('Kegiatan berhasil diubah.', [
                'redirect' => route('kegiatan.index')
            ]);
        } catch (\Exception $e) {
            return $this->error('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->kegiatanService->deleteActivity($id);
            return $this->success('Kegiatan berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus data.');
        }
    }

    /**
     * Remove multiple resources from storage.
     */
    public function bulkDelete(Request $request)
    {
        try {
            if (!$request->filled('ids') || !is_array($request->ids)) {
                return $this->error('Tidak ada data terpilih.');
            }

            $this->kegiatanService->deleteBulkActivities($request->ids);
            return $this->success(count($request->ids) . ' kegiatan berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus data masal.');
        }
    }

    /**
     * Download private attachment
     */
    public function download($uuid)
    {
        $media = Media::where('uuid', $uuid)->firstOrFail();
        
        if ($media->collection_name !== 'lampiran_kegiatan') {
            abort(403, 'Unauthorized access to media.');
        }

        return response()->download($media->getPath(), $media->file_name);
    }
}
