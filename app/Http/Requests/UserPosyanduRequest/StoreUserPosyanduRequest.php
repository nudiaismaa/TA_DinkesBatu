<?php

namespace App\Http\Requests\UserPosyanduRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserPosyanduRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'posyandu_id' => 'required|exists:posyandus,id'
        ];
    }
}
