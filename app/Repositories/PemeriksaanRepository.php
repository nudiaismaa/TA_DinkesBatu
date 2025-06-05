<?php

namespace App\Repositories;

use App\Models\Pemeriksaan;
use App\Repositories\Interfaces\PemeriksaanRepositoryInterface;

class PemeriksaanRepository implements PemeriksaanRepositoryInterface
{
    public function getAllPemeriksaan()
    {
        return Pemeriksaan::all();
    }

    public function getPemeriksaanById($id)
    {
        return Pemeriksaan::with('imunisasi')->findOrFail($id);
    }

    public function createPemeriksaan(array $data)
    {
        return Pemeriksaan::create($data);
    }

    public function updatePemeriksaan($id, array $data)
    {
        $Pemeriksaan = Pemeriksaan::findOrFail($id);

        $Pemeriksaan->update($data);
        return $Pemeriksaan->fresh();
    }

    public function deletePemeriksaan($id)
    {
        return Pemeriksaan::destroy($id);
    }

    public function getPemeriksaanByAnakId($anakId)
    {
        return Pemeriksaan::where('anak_id', $anakId)->get();
    }
}
