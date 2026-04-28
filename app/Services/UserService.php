<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        return $this->userRepository->getAllPagination($perPage, $filters);
    }

    public function createUser(array $data, $roleId)
    {
        if (isset($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        }

        $user = $this->userRepository->create($data);

        // proses sync untuk role
        $user->syncRoles([$roleId]);

        return $user;
    }
}
