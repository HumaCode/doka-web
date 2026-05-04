<?php

namespace App\Repositories\Master\Backup;

interface BackupRepositoryInterface
{
    public function getAll();
    public function findById(string $id);
    public function create(array $data);
    public function delete(string $id);
}
