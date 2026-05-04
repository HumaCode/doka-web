<?php

namespace App\Services\Master\Backup;

use App\Repositories\Master\Backup\BackupRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupService implements BackupServiceInterface
{
    protected $repository;

    public function __construct(BackupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getBackups()
    {
        $histories = $this->repository->getAll();
        
        return $histories->map(function ($history) {
            $media = $history->getFirstMedia('backup_file');
            return [
                'id' => $history->id,
                'file_name' => $media ? $media->file_name : 'No file',
                'file_size' => $media ? $media->human_readable_size : '0 B',
                'last_modified' => $history->created_at->format('d M Y, H:i'),
                'status' => $history->status,
                'download_url' => route('setting.backup.download', $history->id)
            ];
        })->filter(function($b) { return $b['file_name'] !== 'No file'; })->values();
    }

    public function createBackup()
    {
        $tables = [];
        $result = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $tableKey = "Tables_in_{$dbName}";

        foreach ($result as $row) {
            $tables[] = $row->$tableKey;
        }

        $sqlContent = "-- DokaWeb Database Backup\n";
        $sqlContent .= "-- Generated at: " . date('Y-m-d H:i:s') . "\n";
        $sqlContent .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            // Get Create Table Syntax
            $createTable = DB::select("SHOW CREATE TABLE `{$table}`")[0];
            $createTableVar = 'Create Table';
            $sqlContent .= "-- Table structure for `{$table}`\n";
            $sqlContent .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sqlContent .= $createTable->$createTableVar . ";\n\n";

            // Get Data
            $rows = DB::table($table)->get();
            if ($rows->count() > 0) {
                $sqlContent .= "-- Dumping data for `{$table}`\n";
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $columns = array_keys($rowArray);
                    $values = array_values($rowArray);
                    
                    $escapedValues = array_map(function($value) {
                        if ($value === null) return 'NULL';
                        return "'" . addslashes($value) . "'";
                    }, $values);

                    $sqlContent .= "INSERT INTO `{$table}` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $escapedValues) . ");\n";
                }
                $sqlContent .= "\n";
            }
        }

        $sqlContent .= "SET FOREIGN_KEY_CHECKS=1;";

        $fileName = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
        $tempDir = storage_path('app/backup-temp');
        $tempPath = $tempDir . '/' . $fileName;

        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        file_put_contents($tempPath, $sqlContent);

        // Create History Record
        $history = $this->repository->create([
            'name' => 'Database Backup (PHP) ' . date('d M Y H:i'),
            'type' => 'db',
            'status' => 'success'
        ]);

        // Add to Media Library
        $history->addMedia($tempPath)->toMediaCollection('backup_file');

        return true;
    }

    public function downloadBackup(string $id)
    {
        $history = $this->repository->findById($id);
        $media = $history->getFirstMedia('backup_file');
        
        if (!$media) {
            throw new \Exception("File backup tidak ditemukan.");
        }
        
        return $media;
    }

    public function deleteBackup(string $id)
    {
        return $this->repository->delete($id);
    }
}
