<?php

namespace App\Services\Kegiatan;

interface GaleriServiceInterface
{
    /**
     * Get all data for gallery page.
     */
    public function getGalleryData();

    /**
     * Generate ZIP for photos.
     */
    public function generateZip(array $ids = [], array $filters = []);

    /**
     * Delete photos.
     */
    public function deletePhotos(array $ids);

    /**
     * Upload photos.
     */
    public function uploadPhotos(string $kegiatanId, array $files, string $caption = null);
}
