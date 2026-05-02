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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'unit_id' => 'nullable|exists:unit_kerja,id',
            'uraian' => 'required|string',
            'jumlah_peserta' => 'nullable|integer',
            'narasumber' => 'nullable|string|max:255',
            'status' => 'required|in:draft,berjalan,selesai',
            'petugas_id' => 'required|exists:users,id',
            'tags' => 'nullable|string',
            'photos.*' => 'image|max:5120',
            'attachments.*' => 'file|max:10240',
        ]);

        $kegiatan = Kegiatan::create([
            'judul' => $validated['judul'],
            'tanggal' => $validated['tanggal'],
            'waktu' => $validated['waktu'],
            'lokasi' => $validated['lokasi'],
            'kategori_id' => $validated['kategori_id'],
            'unit_id' => $validated['unit_id'],
            'uraian' => $validated['uraian'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'narasumber' => $validated['narasumber'],
            'status' => $validated['status'],
            'petugas_id' => $validated['petugas_id'],
            'tags' => $validated['tags'] ? explode(',', $validated['tags']) : [],
        ]);

        // Photos Upload
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $kegiatan->addMedia($photo)->toMediaCollection('foto_kegiatan');
            }
        }

        // Attachments Upload
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $kegiatan->addMedia($attachment)->toMediaCollection('lampiran_kegiatan');
            }
        }

        \Illuminate\Support\Facades\Cache::forget('kegiatan_stats_global');

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil disimpan.',
            'redirect' => route('kegiatan.index')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Master\Kategori::where('status', 'active')->get();
        $users = \App\Models\User::orderBy('name')->get();
        $units = \App\Models\Master\UnitKerja::orderBy('nama_instansi')->get();
        return view('pages.kegiatan.create', compact('categories', 'users', 'units'));
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
