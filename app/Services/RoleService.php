<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleService {
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository) {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles() {
        return $this->roleRepository->getAllRoles();
    }

    public function getRoleById($id) 
    {
        return $this->roleRepository->getRoleById($id);
    }

    public function createRole(array $data) {
        return $this->roleRepository->createRole($data);
    }

    public function updateRole($id, array $data) {
        return $this->roleRepository->updateRole($id, $data);
    }

    public function deleteRole($id) {
        return $this->roleRepository->deleteRole($id);
    }

    public function getRoleByName(string $name)
    {
        return $this->roleRepository->getRoleByName($name);
    }
}
