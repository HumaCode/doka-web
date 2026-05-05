<?php

namespace App\Repositories\Kegiatan;

interface GaleriRepositoryInterface
{
    /**
     * Get all photos for gallery.
     */
    public function getAllPhotos(array $filters = []);

    /**
     * Get gallery statistics.
     */
    public function getStatistics($photos, array $filters = []);

    /**
     * Get media items for ZIP.
     */
    public function getMediaForZip(array $ids = [], array $filters = []);

    /**
     * Delete media items.
     */
    public function deleteMedia(array $ids);

    /**
     * Upload media items.
     */
    public function uploadMedia(string $kegiatanId, array $files, string $caption = null, string $date = null);
}
