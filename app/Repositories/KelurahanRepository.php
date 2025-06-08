<?php

namespace App\Repositories;

use App\Models\Kelurahan;
use App\Repositories\Interfaces\KelurahanRepositoryInterface;

class KelurahanRepository implements KelurahanRepositoryInterface {
    public function getAllKelurahans() {
        return Kelurahan::all();
    }
}
