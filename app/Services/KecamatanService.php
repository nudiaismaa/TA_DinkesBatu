<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\KecamatanRepositoryInterface;

class KecamatanService
{
    protected $kecamatanRepository;

    public function __construct(KecamatanRepositoryInterface $kecamatanRepository)
    {
        $this->kecamatanRepository = $kecamatanRepository;
    }

    public function getAllKecamatans()
    {
        return $this->kecamatanRepository->getAllKecamatans();
    }
}
