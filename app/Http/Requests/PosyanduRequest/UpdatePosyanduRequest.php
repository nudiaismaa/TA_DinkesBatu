<?php

namespace App\Http\Requests\PosyanduRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePosyanduRequest extends FormRequest {
    public function rules(): array {
        return [
            'nama_posyandu' => 'required|string|max:255|unique:posyandus,nama_posyandu,' . $this->route('id'),
            'kelurahan_id' => 'required|exists:kelurahans,id',
            'rt' => 'required',
            'rw' => 'required',
            'puskesmas_id' => 'required',
        ];
    }
}

