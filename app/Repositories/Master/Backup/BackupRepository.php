<?php

namespace App\Repositories\Master\Backup;

use App\Models\Master\BackupHistory;

class BackupRepository implements BackupRepositoryInterface
{
    public function getAll()
    {
        return BackupHistory::latest()->get();
    }

    public function findById(string $id)
    {
        return BackupHistory::findOrFail($id);
    }

    public function create(array $data)
    {
        return BackupHistory::create($data);
    }

    public function delete(string $id)
    {
        $backup = $this->findById($id);
        return $backup->delete();
    }
}
