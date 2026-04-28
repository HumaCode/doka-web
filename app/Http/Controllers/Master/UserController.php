<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Shield\Role;
use App\Services\Master\Pengguna\UserServiceInterface;
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
        return view('pages.pengguna.index', compact('roles'));
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

        $stats = [
            'total'    => \App\Models\User::count(),
            'active'   => \App\Models\User::where('is_active', '1')->count(),
            'inactive' => \App\Models\User::where('is_active', '0')->count(),
            'admin'    => \App\Models\User::whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            })->count(),
        ];

        return response()->json([
            'success' => true,
            'data'    => UserResource::collection($users->items()),
            'meta'    => [
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
                'per_page'     => $users->perPage(),
                'total'        => $users->total(),
            ],
            'stats'   => $stats,
            'links'   => (string) $users->links(), // For pagination UI if needed
        ]);
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

            return jsonSuccess('Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return jsonError('Terjadi kesalahan sistem ketika menyimpan pengguna. ' . $e->getMessage());
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
            return jsonError('Pengguna tidak ditemukan.', 404);
        }

        return jsonSuccess('Berhasil memuat data pengguna.', [
            'data' => new UserResource($user)
        ]);
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

            return jsonSuccess('Data pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return jsonError('Terjadi kesalahan sistem ketika memperbarui data. ' . $e->getMessage());
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
            return jsonSuccess('Akun pengguna berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            return jsonError('Terjadi kesalahan sistem ketika menghapus data pengguna. ' . $e->getMessage());
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
            return jsonSuccess(count($request->ids) . ' akun pengguna berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            return jsonError('Terjadi kesalahan sistem ketika menghapus bulk pengguna. ' . $e->getMessage());
        }
    }
}
