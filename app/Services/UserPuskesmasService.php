<?php

namespace App\Services;

use App\Http\Requests\UserPuskesmasRequest\UpdateUserPuskesmasRequest;
use App\Models\Role;
use App\Models\UserPuskesmas;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserPuskesmasService
{
    protected $userRepository, $roleRepository;

    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }
    public function getAllUsersWithPuskesmas()
    {
        return $this->userRepository->getAllUsers()->load('puskesmas');
    }

    public function createUserWithPuskesmas(array $data)
    {
        $user = $this->userRepository->createUser($data);

        // Get and assign Puskesmas role
        $role = $this->roleRepository->getRoleByName('Puskesmas');
        if ($role) {
            $user->assignRole($role);
        }

        UserPuskesmas::create([
            'user_id' => $user->id,
            'puskesmas_id' => $data['puskesmas_id'],
        ]);

        return $user;
    }

    public function updateUserWithPuskesmas(array $data, $id)
    {
        $user = $this->userRepository->updateUser($id, $data);

        $role = $this->roleRepository->getRoleByName('Puskesmas');
        if ($role) {
            $user->assignRole($role);
        }

        // Update user_puskesmas table
        UserPuskesmas::updateOrCreate(
            ['user_id' => $user->id],
            ['puskesmas_id' => $data['puskesmas_id']]
        );
        return $user;
    }

    public function deleteUserWithPuskesmas($id)
    {
        $user = $this->userRepository->deleteUser($id);
        UserPuskesmas::where('user_id', $id)->delete();

        return $user;
    }
}
