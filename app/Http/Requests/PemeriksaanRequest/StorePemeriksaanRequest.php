<?php

namespace App\Http\Requests\PemeriksaanRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePemeriksaanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'anak_id' => 'required|exists:anak,id',
            'posyandu_id' => 'nullable|exists:anak,posyandu_id',
            'berat_badan' => 'nullable|numeric|min:0',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'catatan_pemeriksaan' => 'nullable|string',
            'status_imunisasi' => 'nullable|in:Diberikan,Belum Diberikan',
            'jenis_imunisasi' => 'required_if:status_imunisasi,Diberikan',
            'keterangan' => 'nullable|string',
            'hasil_standar' => 'nullable',
            'zscore' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'anak_id.required' => 'Pilih anak terlebih dahulu',
            'anak_id.exists' => 'Data anak tidak ditemukan',
            'berat_badan.numeric' => 'Berat badan harus berupa angka',
            'berat_badan.min' => 'Berat badan harus lebih dari 0',
            'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka',
            'tinggi_badan.min' => 'Tinggi badan harus lebih dari 0',
            'lingkar_kepala.numeric' => 'Lingkar kepala harus berupa angka',
            'lingkar_kepala.min' => 'Lingkar kepala harus lebih dari 0',
            'status_imunisasi.in' => 'Status imunisasi tidak valid',
            'jenis_imunisasi.required_if' => 'Pilih jenis imunisasi jika status imunisasi diberikan',
        ];
    }
}
