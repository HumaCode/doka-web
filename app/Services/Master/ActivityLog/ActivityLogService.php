<?php

namespace App\Services\Master\ActivityLog;

use App\Repositories\Master\ActivityLog\ActivityLogRepositoryInterface;

class ActivityLogService implements ActivityLogServiceInterface
{
    protected $repository;

    public function __construct(ActivityLogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getLogs(array $filters, int $perPage = 25)
    {
        $logs = $this->repository->getAllPagination($filters, $perPage);
        
        $resource = \App\Http\Resources\PaginateResource::make($logs, \App\Http\Resources\Master\ActivityLogResource::class)->toArray(request());
        $resource['stats'] = $this->repository->getStats();

        return $resource;
    }

    public function getLogById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function deleteLog(string $id)
    {
        return $this->repository->delete($id);
    }

    public function getLogStats()
    {
        return $this->repository->getStats();
    }
}
