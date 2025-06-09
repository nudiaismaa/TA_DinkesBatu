<?php

namespace App\Http\Requests\AnakRequest;

use Illuminate\Foundation\Http\FormRequest;

class MovePosyanduRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'anak_id' => 'required|exists:anak,id',
            'posyandu_id' => 'required|exists:posyandus,id'
        ];
    }
}