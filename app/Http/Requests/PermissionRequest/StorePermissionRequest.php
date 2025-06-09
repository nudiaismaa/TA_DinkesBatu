<?php

namespace App\Http\Requests\PermissionRequest;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255|unique:permissions',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'guard_name' => 'web'
        ]);
    }
}