<?php

namespace App\Repositories\Interfaces;

interface JadwalPosyanduRepositoryInterface
{
    public function getAllJadwalPosyandu();
    public function getJadwalPosyanduById($id);
    public function getJadwalPosyanduByPosyanduId($posyanduId);
    public function createJadwalPosyandu(array $data);
    public function updateJadwalPosyandu($id, array $data);
    public function deleteJadwalPosyandu($id);
};
