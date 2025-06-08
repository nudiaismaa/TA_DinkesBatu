<?php

namespace App\Providers;

use App\Repositories\AnakRepository;
use App\Repositories\AuthRepository;
use App\Repositories\ImunisasiRepository;
use App\Repositories\Interfaces\AnakRepositoryInterface;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\ImunisasiRepositoryInterface;
use App\Repositories\Interfaces\JadwalPosyanduRepositoryInterface;
use App\Repositories\Interfaces\JenisImunisasiRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\PosyanduRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PuskesmasRepositoryInterface;
use App\Repositories\Interfaces\KelurahanRepositoryInterface;
use App\Repositories\Interfaces\KecamatanRepositoryInterface;
use App\Repositories\Interfaces\OrangTuaRepositoryInterface;
use App\Repositories\Interfaces\PemeriksaanRepositoryInterface;
use App\Repositories\JadwalPosyanduRepository;
use App\Repositories\JenisImunisasiRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\PosyanduRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\PuskesmasRepository;
use App\Repositories\KelurahanRepository;
use App\Repositories\KecamatanRepository;
use App\Repositories\OrangTuaRepository;
use App\Repositories\PemeriksaanRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PuskesmasRepositoryInterface::class, PuskesmasRepository::class);
        $this->app->bind(KelurahanRepositoryInterface::class, KelurahanRepository::class);
        $this->app->bind(KecamatanRepositoryInterface::class, KecamatanRepository::class);
        $this->app->bind(PosyanduRepositoryInterface::class, PosyanduRepository::class);
        $this->app->bind(OrangTuaRepositoryInterface::class, OrangTuaRepository::class);
        $this->app->bind(AnakRepositoryInterface::class, AnakRepository::class);
        $this->app->bind(ImunisasiRepositoryInterface::class, ImunisasiRepository::class);
        $this->app->bind(JadwalPosyanduRepositoryInterface::class, JadwalPosyanduRepository::class);
        $this->app->bind(JenisImunisasiRepositoryInterface::class, JenisImunisasiRepository::class);
        $this->app->bind(PemeriksaanRepositoryInterface::class, PemeriksaanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
