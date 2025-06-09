<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrangTuaRequest\StoreOrangTuaRequest;
use App\Http\Requests\OrangTuaRequest\UpdateOrangTuaRequest;
use App\Models\Posyandu;
use App\Services\RoleService;
use App\Services\KelurahanService;
use App\Services\OrangTuaService;
use Spatie\Permission\Traits\HasRoles;


class OrangTuaController extends Controller
{
    protected $roleService, $kelurahanService, $orangTuaService;

    public function __construct(RoleService $roleService, KelurahanService $kelurahanService, OrangTuaService $orangTuaService)
    {
        $this->roleService = $roleService;
        $this->kelurahanService = $kelurahanService;
        $this->orangTuaService = $orangTuaService;
    }

    public function index()
    {
        $orangtua = $this->orangTuaService->getAllOrangTua();

        return view('orangtua.index', ['orangtua' => $orangtua, 'kelurahans' => $this->kelurahanService->getAllKelurahans()]);
    }

    public function show($id)
    {
        $orangtua = $this->orangTuaService->getOrangTuaById($id);
        $posyandu = Posyandu::all();
        return view('orangtua.detail', ['orangtua' => $orangtua, 'posyandu' => $posyandu]);
    }

    public function store(StoreOrangTuaRequest $request)
    {
        $this->orangTuaService->createOrangTua($request->validated());
        return redirect()->back()->with('success', 'User Berhasil Ditambahkan');
    }

    public function destroy($id)
    {
        $this->orangTuaService->deleteOrangTua($id);
        return redirect()->back()->with('success', 'User Berhasil Dihapus');
    }


    public function update(UpdateOrangTuaRequest $request, $id)
    {
        $user = $this->orangTuaService->updateOrangTua($id, $request->validated());

        $userRoles = $user->roles->pluck('name')->toArray();
        return redirect()->back()->with([
            'success' => 'Data User Berhasil Diubah',
            'userRoles' => $userRoles
        ]);
    }
}
