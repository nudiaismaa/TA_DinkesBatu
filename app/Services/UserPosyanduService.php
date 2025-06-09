<?php

namespace App\Services;

use App\Models\UserPosyandu;
use App\Models\UserPuskesmas;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserPosyanduService
{
    protected $userRepository, $roleRepository;

    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }
    public function getAllUsersWithPosyandu()
    {
        return $this->userRepository->getAllUsers()->load('posyandu');
    }

    public function createUserWithPosyandu(array $data)
    {
        $user = $this->userRepository->createUser($data);

        // Get and assign Posyandu role
        $role = $this->roleRepository->getRoleByName('Posyandu');
        if ($role) {
            $user->assignRole($role);
        }

        UserPosyandu::create([
            'user_id' => $user->id,
            'posyandu_id' => $data['posyandu_id'],
        ]);

        return $user;
    }

    public function updateUserWithPosyandu(array $data, $id)
    {
        $user = $this->userRepository->updateUser($id, $data);

        $role = $this->roleRepository->getRoleByName('Posyandu');
        if ($role) {
            $user->assignRole($role);
        }

        // Update user_puskesmas table
        UserPosyandu::updateOrCreate(
            ['user_id' => $user->id],
            ['posyandu_id' => $data['posyandu_id']]
        );
        return $user;
    }

    public function deleteUserWithPosyandu($id)
    {
        $user = $this->userRepository->deleteUser($id);
        UserPuskesmas::where('user_id', $id)->delete();

        return $user;
    }
}
