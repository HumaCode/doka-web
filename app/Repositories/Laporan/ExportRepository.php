<?php

namespace App\Repositories\Laporan;

use App\Models\Kegiatan\Kegiatan;
use App\Models\Laporan\ExportHistory;
use App\Models\Master\Kategori;
use App\Models\Master\UnitKerja;
use Illuminate\Support\Facades\DB;

class ExportRepository implements ExportRepositoryInterface
{
    public function getHistory(string $userId)
    {
        return ExportHistory::with('media')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function getPreviewStats(array $filters)
    {
        $query = Kegiatan::query();

        // Apply filters
        if (!empty($filters['bulan_mulai']) && !empty($filters['bulan_akhir'])) {
            $query->whereBetween(DB::raw('MONTH(tanggal)'), [$filters['bulan_mulai'], $filters['bulan_akhir']]);
        }
        
        if (!empty($filters['tahun'])) {
            $query->whereYear('tanggal', $filters['tahun']);
        }

        if (!empty($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }

        if (!empty($filters['kategori_id'])) {
            $query->where('kategori_id', $filters['kategori_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $totalKegiatan = $query->count();
        $totalFoto = $query->withCount('media')->get()->sum('media_count');
        $unitAktif = (clone $query)->distinct('unit_id')->count('unit_id');
        
        // Get all activities for full preview (or at least a larger sample)
        $kegiatans = (clone $query)->with(['kategori', 'unitKerja'])->latest()->get();

        // Calculations for "Informasi Export" card
        $estimatedPages = ceil($totalKegiatan / 4) + 1; // 1 cover + activities
        $estimatedSize = round($totalKegiatan * 0.001, 2); // 1KB per record approx
        $estimatedTime = $totalKegiatan * 0.5; // 0.5s per record approx

        return [
            'total_kegiatan' => $totalKegiatan,
            'total_foto' => $totalFoto,
            'unit_aktif' => $unitAktif,
            'kegiatans' => $kegiatans,
            'estimasi' => [
                'halaman' => $estimatedPages,
                'ukuran' => $estimatedSize . ' MB',
                'waktu' => $estimatedTime . ' detik'
            ]
        ];
    }

    public function createHistory(array $data)
    {
        return ExportHistory::create($data);
    }

    public function deleteHistory(string $id)
    {
        $history = ExportHistory::findOrFail($id);
        return $history->delete(); // This will trigger Spatie's media deletion if configured
    }
}
