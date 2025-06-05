<?php

namespace App\Http\Controllers;

use App\Services\AnakService;
use App\Services\OrangTuaService;
use App\Services\RoleService;



class DashboardController extends Controller
{

    protected $anakService, $orangTuaService, $roleService;

    public function __construct(AnakService $anakService, OrangTuaService $orangTuaService, RoleService $roleService)
    {
        $this->anakService = $anakService;
        $this->orangTuaService = $orangTuaService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        return view('dashboard.index', ['countAnak' => $this->anakService->countAllAnak(), 'anak' => $this->anakService->getAllAnak(), 'countOrangTua' => $this->orangTuaService->countAllOrangTua(), 'orangtua' => $this->orangTuaService->getAllOrangTua(), 'anakByOrangTua' => $this->anakService->getAnakByOrangTuaId(auth()->user()->id), 'anakByPosyandu' => $this->anakService->getAnakByPosyandu(auth()->user()->posyandu_id), 'anakByPuskesmas' => $this->anakService->getAnakByOrangTuaId(auth()->user()->puskesmas_id), 'anakByPosyanduCount' => $this->anakService->getAnakByPosyandu(auth()->user()->posyandu_id)->count(), 'userRoles' => auth()->user()->getRoleNames()]);
    }
}
