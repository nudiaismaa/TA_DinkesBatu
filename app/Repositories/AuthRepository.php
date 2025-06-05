<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface {
    public function login(array $credentials): array 
    {
        return $credentials;
    }

    public function logout(): void 
    {
        Auth::logout();
    }

    public function register(array $data) {
        $data['password'] = bcrypt($data['password']);
        $data['user_status_id'] = 2;
        return User::create($data);
    }
}
