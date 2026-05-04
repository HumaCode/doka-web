<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\ActivityLogResource;
use App\Services\Master\ActivityLog\ActivityLogServiceInterface;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    protected $service;

    public function __construct(ActivityLogServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display the index page.
     */
    public function index()
    {
        return view('pages.setting.activity-log.index');
    }

    /**
     * Get all logs with pagination for AJAX.
     */
    public function getAllPagination(Request $request)
    {
        $filters = $request->only(['search', 'user_id', 'event', 'log_name']);
        $data = $this->service->getLogs($filters, $request->per_page ?? 25);

        return $this->success(null, $data);
    }

    /**
     * Get detail log.
     */
    public function show($id)
    {
        try {
            $log = $this->service->getLogById($id);
            return $this->success(null, new ActivityLogResource($log));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Delete log.
     */
    public function destroy($id)
    {
        try {
            $this->service->deleteLog($id);
            return $this->success('Log berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
