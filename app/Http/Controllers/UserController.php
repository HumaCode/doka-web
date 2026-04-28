<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Shield\Role;
use App\Services\UserServiceInterface;
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
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\App\Http\Requests\StoreUserRequest $request)
    {
        try {
            $data = $request->validated();

            $roleId = $data['role'];
            unset($data['role']);

            $this->userService->createUser($data, $roleId);

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil ditambahkan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem ketika menyimpan pengguna.'
            ], 500);
        }
    }
}
