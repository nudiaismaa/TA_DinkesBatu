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
}
