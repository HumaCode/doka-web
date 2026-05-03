<?php

namespace App\Services\Laporan;

use App\Repositories\Laporan\LaporanRepositoryInterface;

class LaporanService implements LaporanServiceInterface
{
    protected $laporanRepository;

    public function __construct(LaporanRepositoryInterface $laporanRepository)
    {
        $this->laporanRepository = $laporanRepository;
    }

    /**
     * Get data for monthly report page.
     */
    public function getMonthlyReportData(array $filters)
    {
        // Default to current month/year if not provided
        $filters['bulan'] = $filters['bulan'] ?? date('m');
        $filters['tahun'] = $filters['tahun'] ?? date('Y');

        $data = $this->laporanRepository->getMonthlyReportData($filters);
        $stats = $this->laporanRepository->getMonthlyStats($filters);

        // Map data to the format expected by the frontend
        $mappedData = $data->map(function($k) {
            return [
                'id' => $k->id,
                'nama' => $k->judul,
                'tgl' => $k->tanggal->format('Y-m-d'),
                'kat' => $k->kategori->nama_kategori ?? 'Umum',
                'unit' => $k->unitKerja->nama_instansi ?? '—',
                'status' => $k->status,
                'foto' => $k->foto_count,
            ];
        });

        return [
            'kegiatan' => $mappedData,
            'stats' => $stats,
            'filters' => $filters
        ];
    }
}
