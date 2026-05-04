<?php

namespace App\Services\Master\Backup;

interface BackupServiceInterface
{
    public function getBackups();
    public function createBackup();
    public function downloadBackup(string $id);
    public function deleteBackup(string $id);
}
