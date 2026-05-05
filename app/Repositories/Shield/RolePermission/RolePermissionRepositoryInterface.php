<?php

namespace App\Repositories\Shield\RolePermission;

interface RolePermissionRepositoryInterface
{
    public function getAllRoles();
    public function getAllPermissions();
    public function getRoleById($id);
    public function createRole(array $data);
    public function updateRole($id, array $data);
    public function deleteRole($id);
    public function syncPermissions($roleId, array $permissions);
    public function copyPermissions($fromRoleId, $toRoleId);
    public function getCounts();
}
