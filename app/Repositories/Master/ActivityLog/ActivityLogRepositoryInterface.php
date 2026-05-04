<?php

namespace App\Repositories\Master\ActivityLog;

interface ActivityLogRepositoryInterface
{
    public function getAllPagination(array $filters, int $perPage = 25);
    public function findById(string $id);
    public function delete(string $id);
    public function getStats();
}
