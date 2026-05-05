<?php

namespace App\Services\Shield\RolePermission;

interface RolePermissionServiceInterface
{
    public function getRoleData();
    public function getPermissionsByGroup();
    public function getCounts();
    public function getRoleById($id);
    public function createRole(array $data);
    public function updateRole($id, array $data);
    public function deleteRole($id);
    public function updatePermissions($roleId, array $permissions);
    public function copyPermissions($fromRoleId, $toRoleId);
}
