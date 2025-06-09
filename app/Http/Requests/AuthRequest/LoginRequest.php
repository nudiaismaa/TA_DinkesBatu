<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    public function rules(): array {
        return [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8'
        ];
    }
    public function credentials(): array
    {
        return $this->validated();
    }
}
