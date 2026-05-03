<?php

namespace App\Services\Kegiatan;

use Illuminate\Pagination\LengthAwarePaginator;

interface KegiatanServiceInterface
{
    /**
     * Get list of activities.
     */
    public function getActivities(int $perPage = 10, array $filters = []): LengthAwarePaginator;

    /**
     * Create a new activity with media.
     */
    public function createActivity(array $data, array $files = []);

    /**
     * Get activity details by ID.
     */
    public function getActivityById($id);

    /**
     * Update activity and manage media.
     */
    public function updateActivity($id, array $data, array $files = [], array $deletedMedia = []);

    /**
     * Delete an activity and its media.
     */
    public function deleteActivity($id);

    /**
     * Delete multiple activities.
     */
    public function deleteBulkActivities(array $ids);

    /**
     * Get related activities.
     */
    public function getRelatedActivities($id, int $limit = 6);

    /**
     * Get dashboard statistics.
     */
    public function getDashboardStats(array $filters = []);
}
