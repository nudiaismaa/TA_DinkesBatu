<?php

namespace App\Repositories;

use App\Models\OrangTua;
use App\Models\User;
use App\Repositories\Interfaces\OrangTuaRepositoryInterface;

class OrangTuaRepository implements OrangTuaRepositoryInterface
{
    public function getAllOrangTua()
    {
        return OrangTua::all();
    }
    public function countAllOrangTua()
    {
        return OrangTua::count();
    }

    public function getOrangTuaById($id)
    {
        return OrangTua::with('user', 'kelurahan','anak')->findOrFail($id);
    }

    public function createOrangTua(array $data)
    {
        return OrangTua::create($data);
    }

    public function updateOrangTua($id, array $data)
    {
        $orangtua = OrangTua::findOrFail($id);

        $orangtua->update($data);
        return $orangtua->load('roles')->fresh();
    }

    public function deleteOrangTua($id)
    {
        User::destroy($id);
        return OrangTua::destroy($id);
    }
}
