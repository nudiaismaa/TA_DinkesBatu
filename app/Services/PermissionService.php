<?php

namespace App\Services;

use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService {
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository) {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions() {
        return $this->permissionRepository->getAllPermissions();
    }

    public function createPermission(array $data) {
        return $this->permissionRepository->createPermission($data);
    }

    public function updatePermission($id, array $data) {
        return $this->permissionRepository->updatePermission($id, $data);
    }

    public function deletePermission($id) {
        return $this->permissionRepository->deletePermission($id);
    }
}
