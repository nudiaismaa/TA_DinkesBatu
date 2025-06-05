<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\KelurahanRepositoryInterface;

class KelurahanService
{
    protected $kelurahanRepository;

    public function __construct(KelurahanRepositoryInterface $kelurahanRepository)
    {
        $this->kelurahanRepository = $kelurahanRepository;
    }

    public function getAllKelurahans()
    {
        return $this->kelurahanRepository->getAllKelurahans();
    }
}
