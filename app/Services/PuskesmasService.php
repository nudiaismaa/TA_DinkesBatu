<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\PuskesmasRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class PuskesmasService
{
    protected $puskesmasRepository;

    public function __construct(PuskesmasRepositoryInterface $puskesmasRepository)
    {
        $this->puskesmasRepository = $puskesmasRepository;
    }

    public function getAllPuskesmas()
    {
        return $this->puskesmasRepository->getAllPuskesmas();
    }
    public function getPuskesmasById($id)
    {
        return $this->puskesmasRepository->getPuskesmasById($id);
    }

    public function createPuskesmas(array $data)
    {
        return $this->puskesmasRepository->createPuskesmas($data);
    }

    public function UpdatePuskesmas($id, array $data)
    {
        return $this->puskesmasRepository->updatePuskesmas($id, $data);
    }

    public function deletePuskesmas($id)
    {
        return $this->puskesmasRepository->deletePuskesmas($id);
    }
}
