<?php

namespace App\Services\Master\ActivityLog;

interface ActivityLogServiceInterface
{
    public function getLogs(array $filters, int $perPage = 25);
    public function getLogById(string $id);
    public function deleteLog(string $id);
    public function getLogStats();
}
