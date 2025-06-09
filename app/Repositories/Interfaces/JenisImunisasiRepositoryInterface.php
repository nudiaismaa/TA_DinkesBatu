<?php

namespace App\Repositories\Interfaces;

interface JenisImunisasiRepositoryInterface
{
    public function getAllJenisImunisasi();
    public function getJenisImunisasiById($id);
};
