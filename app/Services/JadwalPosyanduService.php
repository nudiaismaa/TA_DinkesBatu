<?php

namespace App\Services;

use App\Repositories\Interfaces\JadwalPosyanduRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class JadwalPosyanduService
{
    protected $jadwalPosyanduRepository;

    public function __construct(JadwalPosyanduRepositoryInterface $jadwalPosyanduRepository)
    {
        $this->jadwalPosyanduRepository = $jadwalPosyanduRepository;
    }
    public function getAllJadwalPosyandu()
    {
        return $this->jadwalPosyanduRepository->getAllJadwalPosyandu();
    }

    public function getJadwalPosyanduById($id)
    {
        return $this->jadwalPosyanduRepository->getJadwalPosyanduById($id);
    }
    public function getJadwalPosyanduByPosyanduId($posyanduId)
    {
        return $this->jadwalPosyanduRepository->getJadwalPosyanduByPosyanduId($posyanduId);
    }

    public function createJadwalPosyandu(array $data)
    {
        $jadwalPosyandu = $this->jadwalPosyanduRepository->createJadwalPosyandu($data);
        return $jadwalPosyandu;
    }

    public function updateJadwalPosyandu(array $data, $id)
    {
        $jadwalPosyandu = $this->jadwalPosyanduRepository->updateJadwalPosyandu($id, $data);

        return $jadwalPosyandu;
    }

    public function deleteJadwalPosyandu($id)
    {
        $jadwalPosyandu = $this->jadwalPosyanduRepository->deleteJadwalPosyandu($id);

        return $jadwalPosyandu;
    }
}
