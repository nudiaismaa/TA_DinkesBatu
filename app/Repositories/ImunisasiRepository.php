<?php

namespace App\Repositories;

use App\Models\Imunisasi;
use App\Repositories\Interfaces\ImunisasiRepositoryInterface;

class ImunisasiRepository implements ImunisasiRepositoryInterface
{
    public function getAllImunisasi()
    {
        return Imunisasi::all();
    }

    public function getImunisasiById($id)
    {
        return Imunisasi::with('jenis_imunisasi')->findOrFail($id);
    }

    public function createImunisasi(array $data)
    {
        return Imunisasi::create($data);
    }

    public function updateImunisasi($id, array $data)
    {
        $Imunisasi = Imunisasi::findOrFail($id);

        $Imunisasi->update($data);
        return $Imunisasi->fresh();
    }

    public function deleteImunisasi($id)
    {
        return Imunisasi::destroy($id);
    }

    public function getImunisasiByPemeriksaanId($pemeriksaanId)
    {
        return Imunisasi::where('pemeriksaan_id', $pemeriksaanId)
            ->with('jenis_imunisasi')
            ->first();
    }
}
