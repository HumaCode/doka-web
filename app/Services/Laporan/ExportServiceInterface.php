<?php

namespace App\Services\Laporan;

interface ExportServiceInterface
{
    /**
     * Get all data for the export page.
     *
     * @return array
     */
    public function getExportPageData();

    /**
     * Get preview statistics based on current filters.
     *
     * @param array $filters
     * @return array
     */
    public function getPreview(array $filters);

    /**
     * Process the export request.
     *
     * @param array $data
     * @return \App\Models\Laporan\ExportHistory
     */
    public function processExport(array $data);

    /**
     * Get the media file for downloading.
     *
     * @param string $id
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media
     */
    public function getDownloadMedia(string $id);

    /**
     * Delete history record and its associated file.
     *
     * @param string $id
     * @return bool
     */
    public function deleteHistory(string $id);
}
