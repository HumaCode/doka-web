<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Laporan\ExportRequest;
use App\Services\Laporan\ExportServiceInterface;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportServiceInterface $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Display the export PDF page.
     */
    public function index()
    {
        $data = $this->exportService->getExportPageData();
        return view('pages.laporan.export-pdf', $data);
    }

    /**
     * Get preview statistics.
     */
    public function getPreview(Request $request)
    {
        try {
            $stats = $this->exportService->getPreview($request->all());
            return $this->success('Statistik pratinjau berhasil diambil.', $stats);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil statistik pratinjau.');
        }
    }

    /**
     * Display the full preview page.
     */
    public function previewFull(Request $request)
    {
        $data = $this->exportService->getPreview($request->all());
        $data['filters'] = $request->all();
        $data['type'] = $request->get('type', 'laporan-bulanan');
        $data['title'] = $request->get('title', 'LAPORAN');
        $data['options'] = $request->get('options', []);
        
        return view('pages.laporan.preview-pdf', $data);
    }

    /**
     * Process the export.
     */
    public function store(ExportRequest $request)
    {
        try {
            $history = $this->exportService->processExport($request->validated());
            return $this->success('Dokumen PDF berhasil di-export.', $history);
        } catch (\Exception $e) {
            return $this->error('Gagal memproses ekspor PDF: ' . $e->getMessage());
        }
    }

    /**
     * Download an export history file.
     */
    public function download($id)
    {
        try {
            $media = $this->exportService->getDownloadMedia($id);
            return response()->download($media->getPath(), $media->file_name);
        } catch (\Exception $e) {
            return redirect()->route('laporan.export-pdf')
                ->with('error', 'File tidak ditemukan atau sudah dihapus.');
        }
    }

    /**
     * Delete history record.
     */
    public function destroy($id)
    {
        try {
            $this->exportService->deleteHistory($id);
            return $this->success('Riwayat ekspor berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus riwayat ekspor.');
        }
    }
}
