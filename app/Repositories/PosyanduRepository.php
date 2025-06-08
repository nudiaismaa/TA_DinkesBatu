<?php

namespace App\Repositories;

use App\Models\Posyandu;
use App\Repositories\Interfaces\PosyanduRepositoryInterface;

class PosyanduRepository implements PosyanduRepositoryInterface
{
    public function getAllPosyandu()
    {
        return Posyandu::all();
    }

    public function getPosyanduById($id)
    {
        return Posyandu::with('jadwal_posyandu')->findOrFail($id);
    }

    public function createPosyandu(array $data)
    {
        return Posyandu::create($data);
    }

    public function updatePosyandu($id, array $data)
    {
        $Posyandu = Posyandu::findOrFail($id);
        $Posyandu->update($data);
        return $Posyandu->load('puskesmas')->fresh();
    }

    public function deletePosyandu($id)
    {
        return Posyandu::destroy($id);
    }
    public function getPosyanduByPuskesmasId($puskesmasId)
    {
        return Posyandu::where('puskesmas_id', $puskesmasId)->get();
    }
}
