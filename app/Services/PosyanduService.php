<?php

namespace App\Services;

use App\Repositories\Interfaces\PosyanduRepositoryInterface;

class PosyanduService
{
    protected $posyanduRepository;

    public function __construct(PosyanduRepositoryInterface $posyanduRepository)
    {
        $this->posyanduRepository = $posyanduRepository;
    }

    public function getAllPosyandu()
    {
        return $this->posyanduRepository->getAllPosyandu();
    }

    public function getPosyanduById($id)
    {
        return $this->posyanduRepository->getPosyanduById($id);
    }

    public function createPosyandu(array $data)
    {
        return $this->posyanduRepository->createPosyandu($data);
    }

    public function updatePosyandu($id, array $data)
    {
        return $this->posyanduRepository->updatePosyandu($id, $data);
    }

    public function deletePosyandu($id)
    {
        return $this->posyanduRepository->deletePosyandu($id);
    }
    public function getPosyanduByPuskesmasId($puskesmasId)
    {
        return $this->posyanduRepository->getPosyanduByPuskesmasId($puskesmasId);
    }
}
