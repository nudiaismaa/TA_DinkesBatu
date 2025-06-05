<?php

namespace App\Repositories\Interfaces;

interface PemeriksaanRepositoryInterface
{
    public function getAllPemeriksaan();
    public function getPemeriksaanById($id);
    public function createPemeriksaan(array $data);
    public function updatePemeriksaan($id, array $data);
    public function deletePemeriksaan($id);
    public function getPemeriksaanByAnakId($anakId);
};
