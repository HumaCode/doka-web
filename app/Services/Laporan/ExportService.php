<?php

namespace App\Services\Laporan;

use App\Repositories\Laporan\ExportRepositoryInterface;
use App\Models\Master\Kategori;
use App\Models\Master\UnitKerja;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExportService implements ExportServiceInterface
{
    protected $exportRepository;

    public function __construct(ExportRepositoryInterface $exportRepository)
    {
        $this->exportRepository = $exportRepository;
    }

    public function getExportPageData()
    {
        $history = $this->exportRepository->getHistory(Auth::id());

        // Append download_url to each history item
        $history->each(function ($item) {
            $item->download_url = route('laporan.export-pdf.download', $item->id);
        });

        return [
            'categories' => Kategori::where('status', 'active')->get(),
            'units' => UnitKerja::where('status', 'active')->get(),
            'history' => $history
        ];
    }

    public function getPreview(array $filters)
    {
        return $this->exportRepository->getPreviewStats($filters);
    }

    public function processExport(array $data)
    {
        $filters = $data['filters'] ?? [];
        $options = $data['options'] ?? [];
        $type = $data['type'] ?? 'laporan-bulanan';
        $title = $data['title'] ?? 'Laporan Export';

        // 1. Fetch real data from repository
        $previewData = $this->exportRepository->getPreviewStats($filters);
        $kegiatans = $previewData['kegiatans'];

        // 2. Determine paper config
        $paperSize = $options['paper_size'] ?? 'a4';
        $orientation = $options['orientation'] ?? 'portrait';

        // 3. Render the PDF via DomPDF
        $pdf = Pdf::loadView('pages.laporan.export-pdf-render', [
            'kegiatans' => $kegiatans,
            'type' => $type,
            'title' => $title,
            'filters' => $filters,
            'options' => $options,
        ]);

        $pdf->setPaper($paperSize, $orientation);

        // Render to get page count
        $pdfContent = $pdf->output();
        $pageCount = preg_match_all('/\/Type\s*\/Page[^s]/', $pdfContent);
        if ($pageCount < 1) $pageCount = 1;

        // 4. Create history record
        $history = $this->exportRepository->createHistory([
            'user_id' => Auth::id(),
            'type' => $type,
            'title' => $title,
            'params' => $filters,
            'page_count' => $pageCount,
        ]);

        // 5. Save PDF to temp file
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $fileName = Str::slug($title) . '-' . now()->format('Ymd-His') . '.pdf';
        $tempPath = $tempDir . '/' . $fileName;
        file_put_contents($tempPath, $pdfContent);

        // 6. Attach to Spatie Media Library
        $history->addMedia($tempPath)
            ->usingFileName($fileName)
            ->toMediaCollection('export_files');

        // 7. Reload with media and append download_url
        $history->load('media');
        $history->download_url = route('laporan.export-pdf.download', $history->id);

        return $history;
    }

    public function getDownloadMedia(string $id)
    {
        $history = $this->exportRepository->findHistory($id);
        $media = $history->getFirstMedia('export_files');

        if (!$media) {
            throw new \Exception('File media tidak ditemukan.');
        }

        return $media;
    }

    public function deleteHistory(string $id)
    {
        return $this->exportRepository->deleteHistory($id);
    }
}
