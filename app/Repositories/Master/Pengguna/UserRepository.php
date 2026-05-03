<?php

namespace App\Repositories\Master\Pengguna;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAllPagination(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = User::query()->with(['roles', 'unitKerja']);

        // Apply filters with Full-Text Search optimization
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                // Gunakan Full-Text Search untuk kolom identitas (Super cepat untuk jutaan data)
                $q->whereFullText(['name', 'email', 'username', 'phone', 'nip', 'nik', 'jabatan'], $search, ['mode' => 'boolean'])
                  // Tetap gunakan LIKE untuk ID (ULID) agar pencarian ID tetap akurat
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if (isset($filters['role']) && $filters['role'] !== '') {
            $query->role($filters['role']);
        }

        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['unit_kerja_id']) && $filters['unit_kerja_id'] !== '') {
            $query->where('unit_kerja_id', $filters['unit_kerja_id']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->with(['roles', 'unitKerja'])->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->findById($id);
        return $user->delete();
    }

    public function getByIds(array $ids)
    {
        return User::with(['roles', 'unitKerja'])->whereIn('id', $ids)->get();
    }

    public function deleteBulk(array $ids)
    {
        return User::whereIn('id', $ids)->delete();
    }

    public function toggleStatus(string $id)
    {
        $user = $this->findById($id);
        
        // Gunakan perbandingan eksplisit dan set nilai sebagai string '0' atau '1'
        // agar sesuai dengan tipe data ENUM di MySQL
        $newStatus = ($user->is_active == '1' || $user->is_active === true) ? '0' : '1';
        
        $user->is_active = $newStatus;

        if ($newStatus == '1') {
            // Jika diaktifkan, pastikan email dianggap terverifikasi agar bisa login
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->keterangan = "Akun diaktifkan oleh " . auth()->user()->name;
        } else {
            $user->keterangan = "Akun dinonaktifkan oleh " . auth()->user()->name;
        }

        $user->save();
        
        return $user;
    }
}
