<?php

namespace App\Repositories\Laporan;

interface LaporanRepositoryInterface
{
    /**
     * Get monthly activities report data.
     *
     * @param array $filters
     * @return mixed
     */
    public function getMonthlyReportData(array $filters);

    /**
     * Get statistics for monthly report.
     *
     * @param array $filters
     * @return array
     */
    public function getMonthlyStats(array $filters);
}
