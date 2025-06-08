<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserById($id);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function getUserByRole(string $roleName);
    public function toggleUserActive($userId);
};