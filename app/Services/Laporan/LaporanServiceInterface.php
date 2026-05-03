<?php

namespace App\Services\Laporan;

interface LaporanServiceInterface
{
    /**
     * Get data for monthly report page.
     *
     * @param array $filters
     * @return array
     */
    public function getMonthlyReportData(array $filters);
}
