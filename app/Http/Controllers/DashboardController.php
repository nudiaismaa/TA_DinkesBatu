<?php

namespace App\Http\Controllers;

use App\Services\AnakService;
use App\Services\OrangTuaService;
use App\Services\RoleService;
use App\Services\PemeriksaanService;



class DashboardController extends Controller
{

    protected $anakService, $orangTuaService, $roleService, $pemeriksaanService;

    public function __construct(AnakService $anakService, OrangTuaService $orangTuaService, RoleService $roleService, PemeriksaanService $pemeriksaanService)
    {
        $this->anakService = $anakService;
        $this->orangTuaService = $orangTuaService;
        $this->roleService = $roleService;
        $this->pemeriksaanService = $pemeriksaanService;
    }

    public function index()
    {
        if (auth()->user()->hasRole('Puskesmas')) {
            $userPuskesmas = auth()->user()->puskesmas->first()->id;;
            $pemeriksaan = $this->pemeriksaanService->getPemeriksaanByPuskesmasId($userPuskesmas);
            $countAnak = $this->anakService->getAnakByPuskesmas($userPuskesmas);
            $countOrangTua = $countAnak->pluck('orangtua')->unique()->count();
        } elseif (auth()->user()->hasRole('Posyandu')) {
            $userPosyandu = auth()->user()->posyandu->first()->id;
            $countAnak = $this->anakService->getAnakByPosyandu($userPosyandu);
            $pemeriksaan = $this->pemeriksaanService->getPemeriksaanByPosyanduId($userPosyandu);
        } elseif (auth()->user()->hasRole('Orang Tua')) {
            $orangtuaId = auth()->user()->orangtua->first()->id;;
            $pemeriksaan = $this->pemeriksaanService->getAllPemeriksaan();
            $countAnak = $this->anakService->getAnakByOrangTuaId($orangtuaId);
        } else {
            $pemeriksaan = $this->pemeriksaanService->getAllPemeriksaan();
            $countAnak = $this->anakService->getAllAnak();
        }
        return view(
            'dashboard.index',
            [
                'anak' => $this->anakService->getAllAnak(),
                'countOrangTua' => $countOrangTua ?? 0,
                'anakByPuskesmas' => $countAnak->count(),
                'userRoles' => auth()->user()->getRoleNames(),
                'pemeriksaan' => $pemeriksaan,
            ]
        );
    }
}
