<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string',
            'roles' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('password') && empty($this->password)) {
            $this->request->remove('password');
        }
    }
}
