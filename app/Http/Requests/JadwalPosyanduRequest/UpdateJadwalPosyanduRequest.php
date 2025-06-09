<?php

namespace App\Http\Requests\JadwalPosyanduRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJadwalPosyanduRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'posyandu_id' => 'required|exists:posyandus,id',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
        ];
    }
}
