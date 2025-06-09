<?php

namespace App\Http\Requests\PemeriksaanRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePemeriksaanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'anak_id' => 'sometimes|exists:anak,id',
            'posyandu_id' => 'sometimes|exists:posyandus,id',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'lingkar_kepala' => 'nullable|numeric',
            'catatan_pemeriksaan' => 'nullable|string',
            'status_imunisasi' => 'nullable|in:Diberikan,Belum Diberikan',
            'jenis_imunisasi' => 'required_if:status_imunisasi,Diberikan|exists:jenis_imunisasis,id',
            'keterangan' => 'nullable|string'
        ];
    }
}
