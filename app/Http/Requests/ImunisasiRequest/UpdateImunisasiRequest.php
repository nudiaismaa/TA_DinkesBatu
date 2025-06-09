<?php

namespace App\Http\Requests\ImunisasiRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateImunisasiRequest extends FormRequest 
{
    public function rules(): array 
    {
        return [
           'pemeriksaan_id' => 'required|exists:pemeriksaan,id' . $this->route('id'),
            'jenis_imunisasi_id' => 'required|exists:jenis_imunisasis,id',
            'status_imunisasi' => 'required|string',
            'tanggal_pemberian' => 'required|date',
            'keterangan' => 'required|string',
        ];
    }
}
