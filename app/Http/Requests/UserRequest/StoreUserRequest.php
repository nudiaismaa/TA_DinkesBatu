<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required',
        ];
    }
}
