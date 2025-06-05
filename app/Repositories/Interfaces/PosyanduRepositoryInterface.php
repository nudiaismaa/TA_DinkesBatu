<?php

namespace App\Repositories\Interfaces;

interface PosyanduRepositoryInterface
{
    public function getAllPosyandu();
    public function getPosyanduById($id);
    public function createPosyandu(array $data);
    public function updatePosyandu($id, array $data);
    public function deletePosyandu($id);
    public function getPosyanduByPuskesmasId($puskesmasId);
};
