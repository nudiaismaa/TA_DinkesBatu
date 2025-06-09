<?php

namespace App\Repositories;

use App\Models\Anak;
use App\Models\User;
use App\Repositories\Interfaces\AnakRepositoryInterface;

class AnakRepository implements AnakRepositoryInterface
{
    public function getAllAnak()
    {
        return Anak::with('pemeriksaan')->get();
    }

    public function countAllAnak()
    {
        return Anak::all()->count();
    }

    public function countAllAnakByOrangTua($id)
    {
        return Anak::all()->count();
    }

    public function countAllAnakByPuskesmas($id)
    {
        return Anak::all()->count();
    }

    public function countAllAnakByPosyandu($id)
    {
        return Anak::all()->count();
    }

    public function getAnakById($id)
    {
        return Anak::with('pemeriksaan', 'kelurahan', 'posyandu', 'orangtua', 'pemeriksaan')->findOrFail($id);
    }

    public function getAnakByOrangTuaId($id)
    {
        return Anak::where('orangtua_id', $id)->get();
    }

    public function getAnakByPuskesmas($id)
    {
        return Anak::whereHas('posyandu', function ($query) use ($id) {
            $query->whereHas('puskesmas', function ($query) use ($id) {
                $query->where('id', $id);
            });
        })->get();
    }
    
    public function getAnakByPosyandu($id)
    {
        return Anak::where('posyandu_id', $id)->get();
    }
    public function createAnak(array $data)
    {
        if (!isset($data['user_status_id']) || $data['user_status_id'] === null) {
            $data['user_status_id'] = 1;
        }

        return Anak::create($data);
    }

    public function updateAnak($id, array $data)
    {
        $Anak = Anak::findOrFail($id);
        // Check if 'posyandu_id' is null and use the existing value if necessary
        if (!isset($data['posyandu_id']) || $data['posyandu_id'] === null) {
            $data['posyandu_id'] = $Anak->posyandu_id;
        }

        $Anak->update($data);
        return $Anak->fresh();
    }

    public function deleteAnak($id)
    {
        Anak::destroy($id);
        return Anak::destroy($id);
    }

    public function toggleAnakActive($anakId)
    {
        $Anak = Anak::findOrFail($anakId);
        $Anak->user_status_id = $Anak->user_status_id == 1 ? 3 : 1;
        $Anak->save();
        
        return $Anak;
    }
}
