<?php

namespace App\Repositories\Interfaces;

interface OrangTuaRepositoryInterface
{
    public function getAllOrangTua();
    public function countAllOrangTua();
    public function getOrangTuaById($id);
    public function createOrangTua(array $data);
    public function updateOrangTua($id, array $data);
    public function deleteOrangTua($id);
};