<?php

namespace App\Services\Master\UnitKerja;

use App\Repositories\Master\UnitKerja\UnitKerjaRepositoryInterface;

class UnitKerjaService implements UnitKerjaServiceInterface
{
    protected $unitKerjaRepository;

    public function __construct(UnitKerjaRepositoryInterface $unitKerjaRepository)
    {
        $this->unitKerjaRepository = $unitKerjaRepository;
    }

    public function getUnitKerjas($perPage, array $filters)
    {
        return $this->unitKerjaRepository->getAllPagination($perPage, $filters);
    }

    public function getUnitKerjaById($id)
    {
        return $this->unitKerjaRepository->findById($id);
    }

    public function createUnitKerja(array $data)
    {
        return $this->unitKerjaRepository->store($data);
    }

    public function updateUnitKerja($id, array $data)
    {
        return $this->unitKerjaRepository->update($id, $data);
    }

    public function deleteUnitKerja($id)
    {
        return $this->unitKerjaRepository->delete($id);
    }

    public function deleteBulkUnitKerjas(array $ids)
    {
        return $this->unitKerjaRepository->deleteBulk($ids);
    }

    public function toggleUnitKerjaStatus($id)
    {
        return $this->unitKerjaRepository->toggleStatus($id);
    }

    public function bulkToggleStatus(array $ids)
    {
        return $this->unitKerjaRepository->toggleBulkStatus($ids);
    }
}
