<?php

namespace App\Repositories\Master\UnitKerja;

use App\Models\Master\UnitKerja;

class UnitKerjaRepository implements UnitKerjaRepositoryInterface
{
    public function getAllPagination($perPage, array $filters)
    {
        $query = UnitKerja::withCount('users');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->whereFullText(['nama_instansi', 'singkatan', 'nama_kepala', 'deskripsi', 'alamat'], $search, ['mode' => 'boolean'])
                  ->orWhere('id', 'like', "%{$search}%");
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
        $allSelected = UnitKerja::whereIn('id', $ids)->withCount('users')->get();
        
        $toDelete = $allSelected->filter(function($uk) {
            return $uk->users_count == 0;
        })->pluck('id')->toArray();

        $deletedCount = 0;
        if (!empty($toDelete)) {
            $deletedCount = UnitKerja::whereIn('id', $toDelete)->delete();
        }

        return [
            'deleted_count' => $deletedCount,
            'skipped_count' => count($ids) - $deletedCount
        ];
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

    public function toggleBulkStatus(array $ids)
    {
        // Use CASE to toggle status efficiently in one query
        return UnitKerja::whereIn('id', $ids)
            ->update([
                'status' => \DB::raw("CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END")
            ]);
    }
}
