<?php

namespace App\Services\Shield\RolePermission;

use App\Repositories\Shield\RolePermission\RolePermissionRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class RolePermissionService implements RolePermissionServiceInterface
{
    protected $repository;

    public function __construct(RolePermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getRoleData()
    {
        return $this->repository->getAllRoles();
    }

    public function getPermissionsByGroup()
    {
        return $this->repository->getAllPermissions();
    }

    public function getCounts()
    {
        return Cache::remember('role_permission_counts', 600, function () {
            return $this->repository->getCounts();
        });
    }

    public function getRoleById($id)
    {
        return $this->repository->getRoleById($id);
    }

    public function createRole(array $data)
    {
        $role = $this->repository->createRole($data);
        Cache::forget('role_permission_counts');
        return $role;
    }

    public function updateRole($id, array $data)
    {
        $role = $this->repository->updateRole($id, $data);
        return $role;
    }

    public function deleteRole($id)
    {
        $role = $this->repository->getRoleById($id);
        
        // 1. Cek apakah ini role sistem yang kritikal
        if (in_array($role->slug, ['dev', 'super-admin'])) {
            throw new \Exception('Role sistem utama (Dev/Super Admin) tidak dapat dihapus.');
        }

        // 2. Cek apakah masih ada user yang menggunakan role ini
        if ($role->users()->count() > 0) {
            throw new \Exception('Role tidak dapat dihapus karena masih digunakan oleh ' . $role->users()->count() . ' pengguna.');
        }

        $result = $this->repository->deleteRole($id);
        Cache::forget('role_permission_counts');
        return $result;
    }

    public function updatePermissions($roleId, array $permissions)
    {
        $result = $this->repository->syncPermissions($roleId, $permissions);
        // Clear Spatie cache
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return $result;
    }

    public function copyPermissions($fromRoleId, $toRoleId)
    {
        $result = $this->repository->copyPermissions($fromRoleId, $toRoleId);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return $result;
    }
}
