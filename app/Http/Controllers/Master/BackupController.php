<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Services\Master\Backup\BackupServiceInterface;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    protected $service;

    public function __construct(BackupServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Get list of backups from history.
     */
    public function index()
    {
        return response()->json($this->service->getBackups());
    }

    /**
     * Create a new backup.
     */
    public function create()
    {
        try {
            $this->service->createBackup();
            return $this->success('Backup database berhasil dibuat.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Download backup file.
     */
    public function download($id)
    {
        try {
            return $this->service->downloadBackup($id);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    /**
     * Delete backup record and its file.
     */
    public function delete($id)
    {
        try {
            $this->service->deleteBackup($id);
            return $this->success('Riwayat backup berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
