<?php

namespace App\Repositories;

use App\Models\Puskesmas;
use App\Repositories\Interfaces\PuskesmasRepositoryInterface;

class PuskesmasRepository implements PuskesmasRepositoryInterface {
    public function getAllPuskesmas() {
        return Puskesmas::all();
    }

    public function getPuskesmasById($id)
    {
        return Puskesmas::findOrFail($id);
    }

    public function createPuskesmas(array $data) {
        return Puskesmas::create($data);
    }

    public function updatePuskesmas($id, array $data) {
        $Puskesmas = Puskesmas::findOrFail($id);
        $Puskesmas->update($data);
        return $Puskesmas->load('kecamatan')->fresh();
    }

    public function deletePuskesmas($id) {
        return Puskesmas::destroy($id);
    }
}
