<?php

namespace App\Repositories\Interfaces;

interface ImunisasiRepositoryInterface
{
    public function getAllImunisasi();
    public function getImunisasiById($id);
    public function createImunisasi(array $data);
    public function updateImunisasi($id, array $data);
    public function deleteImunisasi($id);
};
