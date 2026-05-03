<?php

namespace App\Repositories\Laporan;

use App\Models\Kegiatan\Kegiatan;
use Illuminate\Support\Facades\DB;

class LaporanRepository implements LaporanRepositoryInterface
{
    /**
     * Get monthly activities report data.
     */
    public function getMonthlyReportData(array $filters)
    {
        $query = Kegiatan::with(['kategori', 'unitKerja'])
            ->withCount('media as foto_count');

        if (!empty($filters['bulan'])) {
            $query->whereMonth('tanggal', $filters['bulan']);
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

        return $query->orderBy('tanggal', 'desc')->get();
    }

    /**
     * Get statistics for monthly report.
     */
    public function getMonthlyStats(array $filters)
    {
        $query = Kegiatan::query();

        if (!empty($filters['bulan'])) {
            $query->whereMonth('tanggal', $filters['bulan']);
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

        // Optimized single query for stats
        $stats = $query->selectRaw('
            count(*) as total_kegiatan,
            count(case when status = "selesai" then 1 end) as total_selesai,
            (select count(*) from media where model_type = "App\\\Models\\\Kegiatan\\\Kegiatan" and model_id in (
                select id from kegiatans k2 where month(k2.tanggal) = ? and year(k2.tanggal) = ?
                ' . (!empty($filters['unit_id']) ? 'and k2.unit_id = ' . (int)$filters['unit_id'] : '') . '
                ' . (!empty($filters['kategori_id']) ? 'and k2.kategori_id = ' . (int)$filters['kategori_id'] : '') . '
            )) as total_foto,
            count(distinct unit_id) as unit_aktif
        ', [$filters['bulan'], $filters['tahun']])->first();

        return [
            'total_kegiatan' => (int) $stats->total_kegiatan,
            'total_selesai' => (int) $stats->total_selesai,
            'total_foto' => (int) $stats->total_foto,
            'unit_aktif' => (int) $stats->unit_aktif,
        ];
    }
}
