<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosyanduRequest\StorePosyanduRequest;
use App\Http\Requests\PosyanduRequest\UpdatePosyanduRequest;
use App\Services\JadwalPosyanduService;
use App\Services\PosyanduService;
use App\Services\PuskesmasService;
use App\Services\UserPosyanduService;
use App\Services\UserService;
use App\Services\KelurahanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosyanduController extends Controller
{
    protected $posyanduService, $puskesmasService, $userService, $jadwalPosyanduService, $kelurahanService;

    public function __construct(PosyanduService $posyanduService, PuskesmasService $puskesmasService, UserService $userService, JadwalPosyanduService $jadwalPosyanduService, KelurahanService $kelurahanService)
    {
        $this->posyanduService = $posyanduService;
        $this->puskesmasService = $puskesmasService;
        $this->userService = $userService;
        $this->jadwalPosyanduService = $jadwalPosyanduService;
        $this->kelurahanService = $kelurahanService;
    }

    public function index()
    {
        if (auth()->user()->hasRole('Puskesmas')) {
            $userPuskesmas = DB::table('user_puskesmas')
                ->where('user_id', auth()->id())
                ->first();

            return view('posyandu.index', [
                'posyandus' => $this->posyanduService->getPosyanduByPuskesmasId($userPuskesmas->puskesmas_id),
                'puskesmas' => $this->puskesmasService->getAllPuskesmas(),
                'users' => $this->userService->getUserByRole('Posyandu'),
                'kelurahans' => $this->kelurahanService->getAllKelurahans(),
            ]);
        }

        return view('posyandu.index', [
            'posyandus' => $this->posyanduService->getAllPosyandu(),
            'puskesmas' => $this->puskesmasService->getAllPuskesmas(),
            'users' => $this->userService->getUserByRole('Posyandu'),
            'kelurahans' => $this->kelurahanService->getAllKelurahans(),
        ]);
    }

    public function show($id)
    {
        return view('posyandu.posyandu.detail', [
            'posyandu' => $this->posyanduService->getPosyanduById($id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePosyanduRequest $request)
    {
        $this->posyanduService->createPosyandu($request->validated());
        return redirect()->back()->with('success', 'Posyandu Berhasil Ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePosyanduRequest $request, $id)
    {
        $this->posyanduService->updatePosyandu($id, $request->validated());

        return redirect()->back()->with('success', 'Data Posyandu Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->posyanduService->deletePosyandu($id);
        return redirect()->back()->with('success', 'Posyandu Berhasil Dihapus');
    }
}
