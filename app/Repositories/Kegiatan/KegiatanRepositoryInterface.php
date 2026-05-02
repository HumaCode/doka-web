<?php

namespace App\Repositories\Kegiatan;

use Illuminate\Pagination\LengthAwarePaginator;

interface KegiatanRepositoryInterface
{
    /**
     * Get all activities with pagination and filtering.
     */
    public function getAllPagination(int $perPage = 10, array $filters = []): LengthAwarePaginator;

    /**
     * Create a new activity.
     */
    public function create(array $data);

    /**
     * Find an activity by ID.
     */
    public function findById($id);

    /**
     * Update an existing activity.
     */
    public function update($id, array $data);

    /**
     * Delete an activity.
     */
    public function delete($id);

    /**
     * Get activities by multiple IDs.
     */
    public function getByIds(array $ids);

    /**
     * Delete multiple activities.
     */
    public function deleteBulk(array $ids);
    
    /**
     * Get related activities.
     */
    public function getRelated($id, int $limit = 6);

    /**
     * Get global statistics.
     */
    public function getStats();
}
