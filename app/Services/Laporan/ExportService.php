<?php

namespace App\Services\Laporan;

use App\Repositories\Laporan\ExportRepositoryInterface;
use App\Models\Master\Kategori;
use App\Models\Master\UnitKerja;
use Illuminate\Support\Facades\Auth;

class ExportService implements ExportServiceInterface
{
    protected $exportRepository;

    public function __construct(ExportRepositoryInterface $exportRepository)
    {
        $this->exportRepository = $exportRepository;
    }

    public function getExportPageData()
    {
        return [
            'categories' => Kategori::where('status', 'active')->get(),
            'units' => UnitKerja::where('status', 'active')->get(),
            'history' => $this->exportRepository->getHistory(Auth::id())
        ];
    }

    public function getPreview(array $filters)
    {
        return $this->exportRepository->getPreviewStats($filters);
    }

    public function processExport(array $data)
    {
        // 1. Prepare data for record
        $historyData = [
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'title' => $data['title'] ?? 'Laporan Export',
            'params' => $data['filters'],
            'page_count' => rand(1, 10), // Dummy for now
        ];

        // 2. Create record
        $history = $this->exportRepository->createHistory($historyData);

        // 3. TODO: Generate actual PDF here
        // For now, we'll simulate by adding a dummy file to Spatie Media Library
        // In a real scenario, you'd use Browsershot/DomPDF and addMedia() from string/disk
        
        // Simulating a file for Spatie
        $dummyPath = storage_path('app/public/dummy_export.pdf');
        if (!file_exists($dummyPath)) {
            file_put_contents($dummyPath, '%PDF-1.4 dummy content');
        }

        $history->addMedia($dummyPath)
            ->preservingOriginal()
            ->toMediaCollection('export_files');

        return $history;
    }

    public function deleteHistory(string $id)
    {
        return $this->exportRepository->deleteHistory($id);
    }
}
