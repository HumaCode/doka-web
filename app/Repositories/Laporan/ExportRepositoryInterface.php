<?php

namespace App\Repositories\Laporan;

interface ExportRepositoryInterface
{
    /**
     * Get export history for a user.
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHistory(string $userId);

    /**
     * Get statistics for preview based on filters.
     *
     * @param array $filters
     * @return array
     */
    public function getPreviewStats(array $filters);

    /**
     * Find an export history record by ID.
     *
     * @param string $id
     * @return \App\Models\Laporan\ExportHistory
     */
    public function findHistory(string $id);

    /**
     * Create a new export history record.
     *
     * @param array $data
     * @return \App\Models\Laporan\ExportHistory
     */
    public function createHistory(array $data);

    /**
     * Delete an export history record.
     *
     * @param string $id
     * @return bool
     */
    public function deleteHistory(string $id);
}
