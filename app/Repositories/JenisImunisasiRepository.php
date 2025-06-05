<?php

namespace App\Repositories;

use App\Models\JenisImunisasi;
use App\Repositories\Interfaces\JenisImunisasiRepositoryInterface;

class JenisImunisasiRepository implements JenisImunisasiRepositoryInterface
{
    public function getAllJenisImunisasi()
    {
        return JenisImunisasi::all();
    }

    public function getJenisImunisasiById($id)
    {
        return JenisImunisasi::findOrFail($id);
    }
}
