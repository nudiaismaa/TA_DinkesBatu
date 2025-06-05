<?php

namespace App\Http\Requests\AnakRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAnakRequest extends FormRequest {
    public function rules(): array {
        return [
            'kelurahan_id' => 'required|exists:orangtua,kelurahan_id',
            'orangtua_id' => 'required|exists:orangtua,id',
            'posyandu_id' => 'required|exists:user_posyandu,posyandu_id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:anak|unique:orangtua',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_badan_saat_lahir' => 'required|numeric|min:0|between:0,5.999',
            'anak_ke' => [
                'required',
                'string',
                Rule::unique('anak')
                    ->where(function ($query) {
                        return $query->where('orangtua_id', $this->orangtua_id);
                    })
            ],
            'alamat' => 'required',
        ];
    }
}
