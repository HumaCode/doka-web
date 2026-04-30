<?php

namespace App\Repositories\Master\UnitKerja;

interface UnitKerjaRepositoryInterface
{
    public function getAllPagination($perPage, array $filters);
    public function findById($id);
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function deleteBulk(array $ids);
    public function toggleStatus($id);
}
