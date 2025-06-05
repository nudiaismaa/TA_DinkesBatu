<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use PHPUnit\Framework\Attributes\IgnoreFunctionForCodeCoverage;

class UserService
{
    protected $userRepository, $roleRepository;

    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function createUser(array $data)
    {
        $user = $this->userRepository->createUser($data);

        if (isset($data['roles'])) {
            $role = $this->roleRepository->getRoleByName($data['roles']);
            if ($role) {
                $user->assignRole($role->name);
            }
        }

        return $user;
    }

    public function updateUser($id, array $data)
    {
        $user = $this->userRepository->updateUser($id, $data);

        if (isset($data['roles'])) {
            $user->syncRoles([$data['roles']]);
        }

        return $user->load('roles');
    }

    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);
    }

    public function getUserByRole(string $roleName)
    {
        return $this->userRepository->getUserByRole($roleName);
    }

    public function toggleUserActive($userId): array
    {
        $user = $this->userRepository->toggleUserActive($userId);
        return [
            'status' => 'success',
            'is_active' => $user->isActive(),
            'message' => $user->isActive() ? 'User activated successfully' : 'User deactivated successfully'
        ];
    }
}
