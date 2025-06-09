<?php

namespace App\Http\Requests\OrangTuaRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrangTuaRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'nik' => 'required|string|max:16|unique:orangtua|unique:anak',
            'nomor_hp' => 'required|string|max:15|unique:orangtua',
            'alamat_ktp' => 'required|string',
            'alamat_domisili' => 'required|string',
            'kelurahan_id' => 'required|exists:kelurahans,id',
        ];
    }
}
