<?php

namespace App\Services\Kegiatan;

use App\Models\Master\UnitKerja;
use App\Models\Kegiatan\Kegiatan;
use App\Http\Resources\Galeri\GaleriResource;
use App\Repositories\Kegiatan\GaleriRepositoryInterface;

class GaleriService implements GaleriServiceInterface
{
    protected $galeriRepo;

    public function __construct(GaleriRepositoryInterface $galeriRepo)
    {
        $this->galeriRepo = $galeriRepo;
    }

    /**
     * Get all data for gallery page.
     */
    public function getGalleryData()
    {
        $photos = $this->galeriRepo->getAllPhotos();
        $stats = $this->galeriRepo->getStatistics($photos);
        $units = UnitKerja::all();
        $kegiatans = Kegiatan::latest()->get();

        return [
            'photos' => GaleriResource::collection($photos)->resolve(),
            'stats' => $stats,
            'units' => $units,
            'kegiatans' => $kegiatans,
        ];
    }

    /**
     * Generate ZIP for photos.
     */
    public function generateZip(array $ids = [], array $filters = [])
    {
        $data = $this->galeriRepo->getMediaForZip($ids, $filters);
        
        if (empty($data)) {
            throw new \Exception('Tidak ada foto yang ditemukan untuk diunduh.');
        }

        $zip = new \ZipArchive();
        $fileName = 'DOKA-Galeri-' . now()->format('Ymd-His') . '.zip';
        $tempPath = storage_path('app/temp/' . $fileName);

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        if ($zip->open($tempPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($data as $item) {
                // Sanitize folder name
                $folderName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $item['kegiatan']);
                $zip->addEmptyDir($folderName);

                foreach ($item['media'] as $media) {
                    $filePath = $media->getPath();
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, $folderName . '/' . $media->file_name);
                    }
                }
            }
            $zip->close();
        }

        return $tempPath;
    }

    /**
     * Delete photos.
     */
    public function deletePhotos(array $ids)
    {
        return $this->galeriRepo->deleteMedia($ids);
    }

    /**
     * Upload photos.
     */
    public function uploadPhotos(string $kegiatanId, array $files, string $caption = null)
    {
        $media = $this->galeriRepo->uploadMedia($kegiatanId, $files, $caption);
        return GaleriResource::collection($media)->resolve();
    }
}
