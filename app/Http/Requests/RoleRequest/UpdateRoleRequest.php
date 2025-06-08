<?php

namespace App\Http\Requests\RoleRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'sometimes|required|string|max:255|unique:roles,name,' . $this->route('id'),
            'permission' => 'sometimes|array',
            'permission.*' => 'exists:permissions,name'
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'guard_name' => 'web'
        ]);
    }
}