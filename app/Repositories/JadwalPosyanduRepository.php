<?php

namespace App\Repositories;

use App\Models\JadwalPosyandu;
use App\Repositories\Interfaces\JadwalPosyanduRepositoryInterface;

class JadwalPosyanduRepository implements JadwalPosyanduRepositoryInterface
{
    public function getAllJadwalPosyandu()
    {
        return JadwalPosyandu::all();
    }

    public function getJadwalPosyanduById($id)
    {
        return JadwalPosyandu::findOrFail($id);
    }
    public function getJadwalPosyanduByPosyanduId($posyanduId)
    {
        return JadwalPosyandu::where('posyandu_id', $posyanduId)->get();
    }

    public function createJadwalPosyandu(array $data)
    {
        return JadwalPosyandu::create($data);
    }

    public function updateJadwalPosyandu($id, array $data)
    {
        $JadwalPosyandu = JadwalPosyandu::findOrFail($id);

        $JadwalPosyandu->update($data);
        return $JadwalPosyandu->fresh();
    }

    public function deleteJadwalPosyandu($id)
    {
        return JadwalPosyandu::destroy($id);
    }
}
