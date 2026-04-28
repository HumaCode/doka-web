<?php

namespace App\Services\Master\Pengguna;

use App\Repositories\Master\Pengguna\UserRepositoryInterface;
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

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function updateUser($id, array $data, $roleId)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->userRepository->update($id, $data);

        // Update role
        $user->syncRoles([$roleId]);

        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->userRepository->findById($id);
        
        // Remove roles
        $user->syncRoles([]);

        return $this->userRepository->delete($id);
    }

    public function deleteBulkUsers(array $ids)
    {
        $users = $this->userRepository->getByIds($ids);
        
        foreach ($users as $user) {
            $user->syncRoles([]);
        }

        return $this->userRepository->deleteBulk($ids);
    }
}
