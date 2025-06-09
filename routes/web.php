<?php

use App\Http\Controllers\AnakController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImunisasiController;
use App\Http\Controllers\JadwalPosyanduController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\UserPosyanduController;
use App\Http\Controllers\UserPuskesmasController;
use App\Models\Pemeriksaan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Group routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::group(['middleware' => ['role:Posyandu|Puskesmas|Super Admin']], function () {
        Route::get('/orangtua', [OrangTuaController::class, 'index'])->name('orangtua.index');
        Route::get('/orangtua/{id}', [OrangTuaController::class, 'show'])->name('orangtua.show');
        Route::post('/orangtua', [OrangTuaController::class, 'store'])->name('orangtua.store');
        Route::put('/orangtua/{id}', [OrangTuaController::class, 'update'])->name('orangtua.update');
        Route::delete('/orangtua/{id}', [OrangTuaController::class, 'destroy'])->name('orangtua.destroy');

        Route::get('/anak', [AnakController::class, 'index'])->name('anak.index');
        Route::post('/anak', [AnakController::class, 'store'])->name('anak.store');
        Route::put('/anak/{id}', [AnakController::class, 'update'])->name('anak.update');
        Route::delete('/anak/{id}', [AnakController::class, 'destroy'])->name('anak.destroy');
        Route::get('/anak/detailReports/{id}', [PemeriksaanController::class, 'showFromAnak'])->name('anak.report');
        Route::post('/anak/move-posyandu', [AnakController::class, 'movePosyandu'])->name('anak.move-posyandu');
        Route::put('/anak/{id}/toggle-active', [AnakController::class, 'toggleActive'])->name('anak.toggle-active');
    });

    Route::get('/imunisasi', [ImunisasiController::class, 'index'])->name('imunisasi.index');
    Route::get('/imunisasi/{id}', [ImunisasiController::class, 'show'])->name('imunisasi.show');
    Route::post('/imunisasi', [ImunisasiController::class, 'store'])->name('imunisasi.store');
    Route::put('/imunisasi/{id}', [ImunisasiController::class, 'update'])->name('imunisasi.update');
    Route::delete('/imunisasi/{id}', [ImunisasiController::class, 'destroy'])->name('imunisasi.destroy');

    Route::get('/jadwalPosyandu', [JadwalPosyanduController::class, 'index'])->name('jadwalPosyandu.index');
    Route::get('/jadwalPosyandu/{id}', [JadwalPosyanduController::class, 'show'])->name('jadwalPosyandu.show');
    Route::post('/jadwalPosyandu', [JadwalPosyanduController::class, 'store'])->name('jadwalPosyandu.store');
    Route::put('/jadwalPosyandu/{id}', [JadwalPosyanduController::class, 'update'])->name('jadwalPosyandu.update');
    Route::delete('/jadwalPosyandu/{id}', [JadwalPosyanduController::class, 'destroy'])->name('jadwalPosyandu.destroy');

    Route::get('/anak', [AnakController::class, 'index'])->name('anak.index');
    Route::get('/laporan-anak', [AnakController::class, 'show'])->name('laporan.show');

    Route::get('/pemeriksaan/export-excel-all', [PemeriksaanController::class, 'exportExcelPemeriksaan'])
        ->name('pemeriksaan.export');
    Route::post('/pemeriksaan/check-today', [PemeriksaanController::class, 'checkTodayExamination'])
        ->name('pemeriksaan.check-today');
    Route::get('/pemeriksaan', [PemeriksaanController::class, 'index'])->name('pemeriksaan.index');
    Route::get('/pemeriksaan/create', [PemeriksaanController::class, 'create'])->name('pemeriksaan.create');
    Route::get('/pemeriksaan/{id}', [PemeriksaanController::class, 'show'])->name('pemeriksaan.show');
    Route::post('/pemeriksaan', [PemeriksaanController::class, 'store'])->name('pemeriksaan.store');
    Route::get('/pemeriksaan/edit/{id}', [PemeriksaanController::class, 'edit'])->name('pemeriksaan.edit');
    Route::put('/pemeriksaan/{id}', [PemeriksaanController::class, 'update'])->name('pemeriksaan.update');
    Route::delete('/pemeriksaan/{id}', [PemeriksaanController::class, 'destroy'])->name('pemeriksaan.destroy');
    Route::get('/pemeriksaan/export-excel/{id}', [PemeriksaanController::class, 'exportExcel'])->name('pemeriksaan.export-excel');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/user/{id}/toggle-active', [UserController::class, 'toggleActive'])->name('user.toggle-active');




    Route::get('/posyandu', [PosyanduController::class, 'index'])->name('posyandu.index');
    Route::get('/posyandu/{id}', [PosyanduController::class, 'show'])->name('posyandu.show');
    Route::post('/posyandu', [PosyanduController::class, 'store'])->name('posyandu.store');
    Route::put('/posyandu/{id}', [PosyanduController::class, 'update'])->name('posyandu.update');
    Route::delete('/posyandu/{id}', [PosyanduController::class, 'destroy'])->name('posyandu.destroy');

    Route::get('/puskesmas', [PuskesmasController::class, 'index'])->name('puskesmas.index');
    Route::get('/puskesmas/{id}', [PuskesmasController::class, 'show'])->name('puskesmas.show');
    Route::post('/puskesmas', [PuskesmasController::class, 'store'])->name('puskesmas.store');
    Route::put('/puskesmas/{id}', [PuskesmasController::class, 'update'])->name('puskesmas.update');
    Route::delete('/puskesmas/{id}', [PuskesmasController::class, 'destroy'])->name('puskesmas.destroy');

    Route::post('/user_puskesmas', [UserPuskesmasController::class, 'store'])->name('user_puskesmas.store');
    Route::put('/user_puskesmas/{id}', [UserPuskesmasController::class, 'update'])->name('user_puskesmas.update');
    Route::delete('/user_puskesmas/{id}', [UserPuskesmasController::class, 'destroy'])->name('user_puskesmas.destroy');
    Route::post('/user-puskesmas/{id}/toggle-active', [UserPuskesmasController::class, 'toggleActive'])->name('user_puskesmas.toggle-active');

    Route::post('/user_posyandu', [UserPosyanduController::class, 'store'])->name('user_posyandu.store');
    Route::put('/user_posyandu/{id}', [UserPosyanduController::class, 'update'])->name('user_posyandu.update');
    Route::delete('/user_posyandu/{id}', [UserPosyanduController::class, 'destroy'])->name('user_posyandu.destroy');
    Route::post('/user-posyandu/{id}/toggle-active', [UserPosyanduController::class, 'toggleActive'])->name('user_posyandu.toggle-active');


    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
});

// Auth routes outside middleware group
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/do-register', [AuthController::class, 'store'])->name('auth.register');
