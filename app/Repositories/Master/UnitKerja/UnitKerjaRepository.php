<?php

namespace App\Repositories\Master\UnitKerja;

use App\Models\Master\UnitKerja;

class UnitKerjaRepository implements UnitKerjaRepositoryInterface
{
    public function getAllPagination($perPage, array $filters)
    {
        $query = UnitKerja::withCount('users');

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('nama_instansi', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('singkatan', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('nama_kepala', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['jenis'])) {
            $query->where('jenis_opd', $filters['jenis']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function findById($id)
    {
        return UnitKerja::withCount('users')->find($id);
    }

    public function store(array $data)
    {
        return UnitKerja::create($data);
    }

    public function update($id, array $data)
    {
        $unitKerja = $this->findById($id);
        if ($unitKerja) {
            $unitKerja->update($data);
        }
        return $unitKerja;
    }

    public function delete($id)
    {
        return UnitKerja::destroy($id);
    }

    public function deleteBulk(array $ids)
    {
        return UnitKerja::whereIn('id', $ids)->delete();
    }

    public function toggleStatus($id)
    {
        $unitKerja = $this->findById($id);
        if ($unitKerja) {
            $unitKerja->status = $unitKerja->status === 'active' ? 'inactive' : 'active';
            $unitKerja->save();
        }
        return $unitKerja;
    }
}
