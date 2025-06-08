<?php

namespace App\Http\Requests\AnakRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnakRequest extends FormRequest 
{
    public function rules(): array 
    {
        return [
            'kelurahan_id' => 'required|exists:orangtua,kelurahan_id',
            'orangtua_id' => 'required|exists:orangtua,id',
            'posyandu_id' => 'nullable|exists:user_posyandu,posyandu_id',
            'nama' => 'required|string|max:255',
            'nik' => [
                'required',
                'string',
                'max:16',
                Rule::unique('anak')->ignore($this->route('id')),
                Rule::unique('orangtua')
            ],
            'tanggal_lahir' => 'required|date',
            'berat_badan_saat_lahir' => 'required|numeric|min:0|between:0,99.999',
            'anak_ke' => [
                'required',
                'string',
                Rule::unique('anak')
                    ->ignore($this->route('id'))
                    ->where(function ($query) {
                        return $query->where('orangtua_id', $this->orangtua_id);
                    })
            ],
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'user_status_id' => 'exists:user_statuses,id',
        ];
    }

    public function messages()
    {
        return [
            'berat_badan_saat_lahir.numeric' => 'Berat badan harus berupa angka',
            'berat_badan_saat_lahir.between' => 'Berat badan harus antara 0 dan 99.999 kg',
            'nik.unique' => 'NIK sudah digunakan',
            'anak_ke.unique' => 'Anak ke-:input sudah terdaftar untuk orang tua ini'
        ];
    }
}
