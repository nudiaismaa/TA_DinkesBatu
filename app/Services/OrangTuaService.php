<?php

namespace App\Services;

use App\Http\Requests\UserPuskesmasRequest\UpdateUserPuskesmasRequest;
use App\Models\OrangTua;
use App\Models\Role;
use App\Models\UserPuskesmas;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\OrangTuaRepositoryInterface;

class OrangTuaService
{
    protected $userRepository, $roleRepository, $orangTuaRepository;

    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository, OrangTuaRepositoryInterface $orangTuaRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->orangTuaRepository = $orangTuaRepository;
    }
    public function getAllOrangTua()
    {
        return $this->orangTuaRepository->getAllOrangTua();
    }
    public function countAllOrangTua()
    {
        return $this->orangTuaRepository->countAllOrangTua();
    }

    public function getOrangTuaById($id)
    {
        return $this->orangTuaRepository->getOrangTuaById($id);
    }

    public function createOrangTua(array $data)
    {
        $user = $this->userRepository->createUser($data);

        // Get and assign Orang Tua role
        $role = $this->roleRepository->getRoleByName('Orang Tua');
        if ($role) {
            $user->assignRole($role);
        }
        
        $data['user_id'] = $user->id;

        $orangtua = $this->orangTuaRepository->createOrangTua($data);

        return $orangtua;
    }

    public function updateOrangTua(array $data, $id)
    {
        $user = $this->userRepository->updateUser($id, $data);

        $role = $this->roleRepository->getRoleByName('Orang Tua');
        if ($role) {
            $user->assignRole($role);
        }

        $orangtua = $this->orangTuaRepository->updateOrangTua($id, $data);

        return $orangtua;
    }

    public function deleteOrangTua($id)
    {
        $user = $this->userRepository->deleteUser($id);

        return $user;
    }
}
