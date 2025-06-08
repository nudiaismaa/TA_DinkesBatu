<?php

namespace App\Services;

use App\Models\Pemeriksaan;

class PemeriksaanExportService
{
    public function getPemeriksaanByAnakId($id)
    {
        return Pemeriksaan::with('anak')->where('anak_id', $id)->get();
    }
}
