<?php

namespace App\Services;

use App\Repositories\Interfaces\PemeriksaanRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PemeriksaanService
{
    protected $pemeriksaanRepository;

    public function __construct(PemeriksaanRepositoryInterface $pemeriksaanRepository)
    {
        $this->pemeriksaanRepository = $pemeriksaanRepository;
    }
    public function getAllPemeriksaan()
    {
        return $this->pemeriksaanRepository->getAllPemeriksaan();
    }

    public function getPemeriksaanById($id)
    {
        return $this->pemeriksaanRepository->getPemeriksaanById($id);
    }

    public function createPemeriksaan(array $data)
    {
        $pemeriksaan = $this->pemeriksaanRepository->createPemeriksaan($data);
        return $pemeriksaan;
    }

    public function updatePemeriksaan(array $data, $id)
    {
        $pemeriksaan = $this->pemeriksaanRepository->updatePemeriksaan($id, $data);

        return $pemeriksaan;
    }

    public function deletePemeriksaan($id)
    {
        $pemeriksaan = $this->pemeriksaanRepository->deletePemeriksaan($id);

        return $pemeriksaan;
    }

    public function getPemeriksaanByAnakId($anakId)
    {
        return $this->pemeriksaanRepository->getPemeriksaanByAnakId($anakId);
    }
    public function getPemeriksaanByPuskesmasId($puskesmasId)
    {
        return $this->pemeriksaanRepository->getPemeriksaanByPuskesmasId($puskesmasId);
    }
    public function getPemeriksaanByPosyanduId($posyanduId)
    {
        return $this->pemeriksaanRepository->getPemeriksaanByPosyanduId($posyanduId);
    }

    public function getPemeriksaanByAnakAndDate($anakId, $date)
    {
        return $this->pemeriksaanRepository->getPemeriksaanByAnakAndDate($anakId, $date);
    }
}
