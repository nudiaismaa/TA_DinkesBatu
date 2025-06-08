<?php

namespace App\Http\Controllers;

use App\Http\Requests\PuskesmasRequest\StorePuskesmasRequest;
use App\Http\Requests\PuskesmasRequest\UpdatePuskesmasRequest;
use App\Services\PuskesmasService;
use App\Services\UserService;
use App\Services\KecamatanService;

class PuskesmasController extends Controller
{
    protected $puskesmasService, $userService, $kecamatanService;

    public function __construct(PuskesmasService $puskesmasService, UserService $userService, KecamatanService $kecamatanService)
    {
        $this->puskesmasService = $puskesmasService;
        $this->userService = $userService;
        $this->kecamatanService = $kecamatanService;
    }

    public function index()
    {
        return view('puskesmas.index', ['puskesmas' => $this->puskesmasService->getAllPuskesmas(), 'kecamatans' => $this->kecamatanService->getAllKecamatans(), 'users' => $this->userService->getUserByRole('Puskesmas')]);
    }

    public function show($id)
    {
        return view('puskesmas.puskesmas.detail', [
            'puskesmas' => $this->puskesmasService->getPuskesmasById($id),
        ]);
    }

    public function store(StorePuskesmasRequest $request)
    {
        $this->puskesmasService->createPuskesmas($request->validated());
        return redirect()->back()->with('success', 'Puskesmas Berhasil Ditambahkan');
    }

    public function update(UpdatePuskesmasRequest $request, $id)
    {
        $this->puskesmasService->UpdatePuskesmas($id, $request->validated());

        return redirect()->back()->with('success', 'Data Puskesmas Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->puskesmasService->deletePuskesmas($id);
        return redirect()->back()->with('success', 'Puskesmas Berhasil Dihapus');
    }
}
