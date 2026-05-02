<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\KegiatanResource;
use App\Http\Resources\PaginateResource;
use App\Models\Master\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Master\Kategori::where('status', 'active')->get();
        return view('pages.kegiatan.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kegiatan.create');
    }

    /**
     * Get all pagination data (AJAX)
     */
    public function getAllPagination(Request $request)
    {
        $query = Kegiatan::with(['kategori', 'unitKerja', 'petugas', 'media']);

        // Filter: Search
        if ($request->filled('search')) {
            $search = $request->search;
            // Using FullText search for performance on large data (5000+)
            $query->whereFullText(['judul', 'uraian', 'lokasi'], $search, ['mode' => 'boolean']);
        }

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter: Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter: Month
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Sorting
        $sortField = $request->get('sort_field', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $perPage = $request->get('per_page', 12);
        $kegiatans = $query->paginate($perPage);

        // Statistics (cached or raw)
        $stats = cache()->remember('kegiatan_stats_global', 300, function() {
            $rawStats = Kegiatan::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
                SUM(CASE WHEN status = 'berjalan' THEN 1 ELSE 0 END) as berjalan,
                SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai
            ")->first();

            return [
                'total' => (int) ($rawStats->total ?? 0),
                'draft' => (int) ($rawStats->draft ?? 0),
                'berjalan' => (int) ($rawStats->berjalan ?? 0),
                'selesai' => (int) ($rawStats->selesai ?? 0),
            ];
        });

        $resource = PaginateResource::make($kegiatans, KegiatanResource::class)->toArray(request());
        $resource['stats'] = $stats;

        return $this->success('Data berhasil dimuat.', $resource);
    }
}
