<?php

namespace App\Services;

use App\Repositories\Interfaces\JenisImunisasiRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class JenisImunisasiService
{
    protected $jenisImunisasiRepository;

    public function __construct(JenisImunisasiRepositoryInterface $jenisImunisasiRepository)
    {
        $this->jenisImunisasiRepository = $jenisImunisasiRepository;
    }
    public function getAllJenisImunisasi()
    {
        return $this->jenisImunisasiRepository->getAllJenisImunisasi();
    }

    public function getJenisImunisasiById($id)
    {
        return $this->jenisImunisasiRepository->getJenisImunisasiById($id);
    }
}
