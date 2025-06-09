<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImunisasiRequest\StoreImunisasiRequest;
use App\Http\Requests\ImunisasiRequest\UpdateImunisasiRequest;
use App\Services\ImunisasiService;
use App\Services\JenisImunisasiService;
use Illuminate\Http\Request;

class ImunisasiController extends Controller
{
    protected $imunisasiService, $jenisImunisasiService;

    public function __construct(ImunisasiService $imunisasiService, JenisImunisasiService $jenisImunisasiService)
    {
        $this->imunisasiService = $imunisasiService;
        $this->jenisImunisasiService = $jenisImunisasiService;
    }

    public function index()
    {
        return view('imunisasi.index', ['imunisasi' => $this->imunisasiService->getAllImunisasi(), 'jenis_imunisasi' => $this->jenisImunisasiService->getAllJenisImunisasi()]);
    }

    public function show($id)
    {
        $imunisasi = $this->imunisasiService->getimunisasiById($id);
        return view('imunisasi.detail', ['imunisasi' => $imunisasi]);
    }

    public function store(StoreImunisasiRequest $request)
    {
        $this->imunisasiService->createimunisasi($request->validated());
        return redirect()->back()->with('success', 'Data Imunisasi Berhasil Ditambahkan');
    }

    public function destroy($id)
    {
        $this->imunisasiService->deleteimunisasi($id);
        return redirect()->back()->with('success', 'Data Imunisasi Berhasil Dihapus');
    }


    public function update(UpdateImunisasiRequest $request, $id)
    {
        $this->imunisasiService->updateimunisasi($id, $request->validated());

        return redirect()->back()->with([
            'success' => 'Data Imunisasi Berhasil Diubah',
        ]);
    }
}
