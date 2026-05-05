<?php

namespace App\Repositories\Shield\RolePermission;

use App\Models\Shield\Role;
use App\Models\Shield\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolePermissionRepository implements RolePermissionRepositoryInterface
{
    public function getAllRoles()
    {
        return Role::with(['permissions'])->withCount(['users'])->get();
    }

    public function getAllPermissions()
    {
        return Permission::all()->groupBy('group');
    }

    public function getRoleById($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function createRole(array $data)
    {
        return Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? \Illuminate\Support\Str::slug($data['name']),
            'guard_name' => $data['guard_name'] ?? 'web',
            'description' => $data['description'] ?? null,
            'icon' => $data['icon'] ?? 'bi-shield-fill',
            'grad_id' => $data['grad_id'] ?? 0,
        ]);
    }

    public function updateRole($id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? $role->slug,
            'description' => $data['description'] ?? $role->description,
            'icon' => $data['icon'] ?? $role->icon,
            'grad_id' => $data['grad_id'] ?? $role->grad_id,
        ]);
        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        return $role->delete();
    }

    public function syncPermissions($roleId, array $permissions)
    {
        $role = Role::findOrFail($roleId);
        return $role->syncPermissions($permissions);
    }

    public function copyPermissions($fromRoleId, $toRoleId)
    {
        $fromRole = Role::findOrFail($fromRoleId);
        $toRole = Role::findOrFail($toRoleId);
        
        $permissions = $fromRole->getPermissionNames();
        return $toRole->syncPermissions($permissions);
    }

    public function getCounts()
    {
        return [
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'active_users' => User::where('is_active', '1')->count(),
            'login_today' => DB::table('activity_log')
                ->where(function($q) {
                    $q->where('event', 'login')
                      ->orWhere('description', 'like', '%login%');
                })
                ->where('created_at', '>=', now()->startOfDay())
                ->count(),
        ];
    }
}
