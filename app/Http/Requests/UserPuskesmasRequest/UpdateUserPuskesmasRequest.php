<?php

namespace App\Http\Requests\UserPuskesmasRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPuskesmasRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string',
            'puskesmas_id' => 'required|exists:puskesmas,id',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('password') && empty($this->password)) {
            $this->request->remove('password');
        }
    }
}
