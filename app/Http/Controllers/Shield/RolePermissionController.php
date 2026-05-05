<?php

namespace App\Http\Controllers\Shield;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shield\RoleStoreRequest;
use App\Http\Requests\Shield\RoleUpdateRequest;
use App\Services\Shield\RolePermission\RolePermissionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolePermissionController extends Controller
{
    protected $service;

    public function __construct(RolePermissionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $roles = $this->service->getRoleData();
        $permissions = $this->service->getPermissionsByGroup();
        $counts = $this->service->getCounts();

        return view('pages.role-permission.index', compact('roles', 'permissions', 'counts'));
    }

    public function store(RoleStoreRequest $request)
    {
        return \DB::transaction(function () use ($request) {
            try {
                $role = $this->service->createRole($request->validated());

                // Handle Copy Permissions
                if ($request->has('copy_from') && !empty($request->copy_from)) {
                    $this->service->copyPermissions($request->copy_from, $role->id);
                }

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Role berhasil ditambahkan.',
                    'data'    => $role
                ]);
            } catch (\Exception $e) {
                \Log::error('Error creating role: ' . $e->getMessage());
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Gagal menambahkan role: ' . $e->getMessage()
                ], 500);
            }
        });
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        try {
            $role = $this->service->updateRole($id, $request->validated());
            return response()->json([
                'status'  => 'success',
                'message' => 'Role berhasil diperbarui.',
                'data'    => $role
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memperbarui role.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->deleteRole($id);
            return response()->json([
                'status'  => 'success',
                'message' => 'Role berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function syncPermissions(Request $request)
    {
        $request->validate([
            'role_id'     => 'required|exists:roles,id',
            'permissions' => 'present|array',
        ]);

        try {
            $this->service->updatePermissions($request->role_id, $request->permissions);
            return response()->json([
                'status'  => 'success',
                'message' => 'Hak akses berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error syncing permissions: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan hak akses.'
            ], 500);
        }
    }
}
