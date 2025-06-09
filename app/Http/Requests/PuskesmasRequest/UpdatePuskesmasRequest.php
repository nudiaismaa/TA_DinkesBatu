<?php

namespace App\Http\Requests\PuskesmasRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePuskesmasRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'kecamatan_id' => 'required',
            'nama_puskesmas' => 'required|string|max:255|unique:puskesmas,nama_puskesmas,' . $this->route('id'),
            'alamat' => 'required|string|max:255',
            'rt' => 'required',
            'rw' => 'required',
        ];
    }
}
