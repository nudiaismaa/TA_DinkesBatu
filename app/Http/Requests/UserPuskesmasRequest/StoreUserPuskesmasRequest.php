<?php

namespace App\Http\Requests\UserPuskesmasRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserPuskesmasRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'puskesmas_id' => 'required|exists:puskesmas,id'
        ];
    }
}
