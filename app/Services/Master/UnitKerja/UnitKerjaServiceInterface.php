<?php

namespace App\Services\Master\UnitKerja;

interface UnitKerjaServiceInterface
{
    public function getUnitKerjas($perPage, array $filters);
    public function getUnitKerjaById($id);
    public function createUnitKerja(array $data);
    public function updateUnitKerja($id, array $data);
    public function deleteUnitKerja($id);
    public function deleteBulkUnitKerjas(array $ids);
    public function toggleUnitKerjaStatus($id);
}
