<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Request;

class AuthService {
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository) {
        $this->authRepository = $authRepository;
    }

    public function login(array $credentials) {
        return $this->authRepository->login($credentials);
    }

    public function logout() {
        return $this->authRepository->logout();
    }

    public function register(array $data) {
        $user = $this->authRepository->register($data);
    
        if (isset($data['roles'])) {
            $role = Role::where('name', $data['roles'])->first();
            if ($role) {
                $user->assignRole($role->name);
            }
        }
    
        return $user;
    }
    
}
