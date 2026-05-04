<?php

namespace App\Repositories\Master\ActivityLog;

use App\Models\Activity;
use Carbon\Carbon;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function getAllPagination(array $filters, int $perPage = 25)
    {
        $query = Activity::with('causer')->latest();

        if (!empty($filters['search'])) {
            $query->where('description', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['user_id'])) {
            $query->where('causer_id', $filters['user_id']);
        }

        if (!empty($filters['event'])) {
            $query->where('event', $filters['event']);
        }

        if (!empty($filters['log_name'])) {
            $query->where('log_name', $filters['log_name']);
        }

        return $query->paginate($perPage);
    }

    public function findById(string $id)
    {
        return Activity::with('causer', 'subject')->findOrFail($id);
    }

    public function delete(string $id)
    {
        $log = Activity::findOrFail($id);
        return $log->delete();
    }

    public function getStats()
    {
        return [
            'total' => Activity::count(),
            'today' => Activity::whereDate('created_at', Carbon::today())->count(),
            'user_logs' => Activity::whereNotNull('causer_id')->count(),
            'system_logs' => Activity::whereNull('causer_id')->count(),
        ];
    }
}
