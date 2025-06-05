<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    public function getAllUsers() {
        return User::all();
    }

    public function getUserById($id) {
        return User::findOrFail($id);
    }

    public function createUser(array $data) {
        $data['password'] = bcrypt($data['password']);
        $data['user_status_id'] = 1;
        return User::create($data);
    }

    public function updateUser($id, array $data) {
        $user = User::findOrFail($id);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);
        return $user->load('roles')->fresh();
    }

    public function deleteUser($id) {
        return User::destroy($id);
    }

    public function getUserByRole(string $roleName)
    {
        return User::role($roleName)->get();
    }
    
    public function toggleUserActive($userId)
    {
        $user = User::findOrFail($userId);
        $user->user_status_id = $user->user_status_id == 1 ? 3 : 1;
        $user->save();
        
        return $user;
    }
}
