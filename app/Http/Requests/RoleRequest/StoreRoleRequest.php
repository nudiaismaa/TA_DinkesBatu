<?php

namespace App\Http\Requests\RoleRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255|unique:roles',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'guard_name' => 'web'
        ]);
    }
}