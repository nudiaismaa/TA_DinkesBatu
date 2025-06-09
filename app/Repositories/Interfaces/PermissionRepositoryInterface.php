<?php

namespace App\Repositories\Interfaces;

interface PermissionRepositoryInterface
{
    public function getAllPermissions();
    public function getPermissionById($id);
    public function createPermission(array $data);
    public function updatePermission($id, array $data);
    public function deletePermission($id);
};