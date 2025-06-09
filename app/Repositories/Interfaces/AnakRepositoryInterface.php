<?php

namespace App\Repositories\Interfaces;

interface AnakRepositoryInterface
{
    public function getAllAnak();
    public function countAllAnak();
    public function countAllAnakByOrangTua($id);
    public function countAllAnakByPuskesmas($id);
    public function countAllAnakByPosyandu($id);
    public function getAnakById($id);
    public function getAnakByOrangTuaId($id);
    public function getAnakByPuskesmas($id);
    public function getAnakByPosyandu($id);
    public function createAnak(array $data);
    public function updateAnak($id, array $data);
    public function deleteAnak($id);
    public function toggleAnakActive($anakId);
};
