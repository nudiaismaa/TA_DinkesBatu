<?php

namespace App\Services;

use App\Repositories\Interfaces\ImunisasiRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ImunisasiService
{
    protected $imunisasiRepository;

    public function __construct(ImunisasiRepositoryInterface $imunisasiRepository)
    {
        $this->imunisasiRepository = $imunisasiRepository;
    }
    public function getAllImunisasi()
    {
        return $this->imunisasiRepository->getAllImunisasi();
    }

    public function getImunisasiById($id)
    {
        return $this->imunisasiRepository->getImunisasiById($id);
    }

    public function createImunisasi(array $data)
    {
        $imunisasi = $this->imunisasiRepository->createImunisasi($data);
        return $imunisasi;
    }

    public function updateImunisasi(array $data, $id)
    {
        $imunisasi = $this->imunisasiRepository->updateImunisasi($id, $data);

        return $imunisasi;
    }

    public function deleteImunisasi($id)
    {
        $imunisasi = $this->imunisasiRepository->deleteImunisasi($id);

        return $imunisasi;
    }
}
