<?php

namespace App\Repositories;

use App\Models\Kecamatan;
use App\Repositories\Interfaces\KecamatanRepositoryInterface;

class KecamatanRepository implements KecamatanRepositoryInterface
{
    public function getAllKecamatans()
    {

        return Kecamatan::all();
    }
}
