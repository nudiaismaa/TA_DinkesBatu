<?php

namespace App\Http\Requests\UserPosyanduRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPosyanduRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string',
            'posyandu_id' => 'required|exists:posyandus,id',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('password') && empty($this->password)) {
            $this->request->remove('password');
        }
    }
}
