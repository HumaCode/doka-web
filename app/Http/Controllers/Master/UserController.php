<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Models\Shield\Role;
use App\Services\Master\Pengguna\UserServiceInterface;
use App\Models\Master\UnitKerja;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $roles = Role::all();
        $unitKerjas = UnitKerja::where('status', 'active')->orderBy('nama_instansi')->get();
        return view('pages.pengguna.index', compact('roles', 'unitKerjas'));
    }

    /**
     * Get all users with pagination for AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPagination(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'role'   => $request->get('role'),
            'is_active' => $request->get('status'), // status filter
        ];

        $perPage = $request->get('per_page', 10);

        $users = $this->userService->getUsers($perPage, $filters);

        // Cache stats for 5 minutes to reduce DB load (Optimized Performance)
        $stats = cache()->remember('user_stats_global', 300, function() {
            $rawStats = \App\Models\User::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN is_active = '1' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN is_active = '0' THEN 1 ELSE 0 END) as inactive
            ")->first();

            return [
                'total'    => (int) ($rawStats->total ?? 0),
                'active'   => (int) ($rawStats->active ?? 0),
                'inactive' => (int) ($rawStats->inactive ?? 0),
                'admin'    => \App\Models\User::role('admin')->count(),
            ];
        });

        $resource = PaginateResource::make($users, UserResource::class)->toArray(request());
        $resource['stats'] = $stats;

        return $this->success(null, $resource);
    }

    /**
     * Store a newly created user via AJAX.
     *
     * @param \App\Http\Requests\Master\Pengguna\StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\App\Http\Requests\Master\Pengguna\StoreUserRequest $request)
    {
        try {
            $data = $request->validated();

            $roleId = $data['role'];
            unset($data['role']);

            $this->userService->createUser($data, $roleId);
            cache()->forget('user_stats_global');

            return $this->success('Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return $this->error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Get details of a single user.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return $this->error('Pengguna tidak ditemukan.', 404);
        }

        return $this->success('Berhasil memuat data pengguna.', new UserResource($user));
    }

    /**
     * Update an existing user via AJAX.
     *
     * @param \App\Http\Requests\Master\Pengguna\UpdateUserRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\App\Http\Requests\Master\Pengguna\UpdateUserRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $roleId = $data['role'];
            unset($data['role']);

            $this->userService->updateUser($id, $data, $roleId);
            cache()->forget('user_stats_global');

            return $this->success('Data pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Delete an existing user via AJAX.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            cache()->forget('user_stats_global');
            return $this->success('Akun pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Delete multiple users via AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyBulk(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        try {
            $this->userService->deleteBulkUsers($request->ids);
            cache()->forget('user_stats_global');
            return $this->success(count($request->ids) . ' akun pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status of the specified user.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(string $id)
    {
        try {
            $user = $this->userService->toggleUserStatus($id);
            $statusText = $user->is_active ? 'Aktif' : 'Nonaktif';
            
            return $this->success("Status akun {$user->name} berhasil diubah menjadi {$statusText}.");
        } catch (\Exception $e) {
            return $this->error('Gagal mengubah status: ' . $e->getMessage());
        }
    }
}
