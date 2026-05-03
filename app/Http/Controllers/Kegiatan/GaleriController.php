<?php

namespace App\Http\Controllers\Kegiatan;

use App\Http\Controllers\Controller;
use App\Services\Kegiatan\GaleriServiceInterface;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    protected $galeriService;

    public function __construct(GaleriServiceInterface $galeriService)
    {
        $this->galeriService = $galeriService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = [];
        if (!auth()->user()->hasRole('dev')) {
            $filters['unit_id'] = auth()->user()->unit_kerja_id;
        }

        $data = $this->galeriService->getGalleryData($filters);
        
        return view('pages.galery.index', [
            'photos' => $data['photos'],
            'stats' => $data['stats'],
            'units' => $data['units'],
            'kegiatans' => $data['kegiatans'],
        ]);
    }

    /**
     * Download photos as ZIP.
     */
    public function downloadZip(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            $filters = $request->input('filters', []);

            // Role-based filtering for ZIP download
            if (!auth()->user()->hasRole('dev')) {
                $filters['unit_id'] = auth()->user()->unit_kerja_id;
            }

            $zipPath = $this->galeriService->generateZip($ids, $filters);

            return response()->download($zipPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                throw new \Exception('Pilih foto yang ingin dihapus.');
            }

            $this->galeriService->deletePhotos($ids);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'kegiatan_id' => 'required|exists:kegiatans,id',
                'photos' => 'required|array',
                'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            $newPhotos = $this->galeriService->uploadPhotos(
                $request->kegiatan_id,
                $request->file('photos'),
                $request->keterangan
            );

            return response()->json([
                'success' => true,
                'message' => count($newPhotos) . ' foto berhasil diunggah',
                'data' => $newPhotos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
