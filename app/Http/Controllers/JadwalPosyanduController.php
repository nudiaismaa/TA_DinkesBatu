<?php

namespace App\Http\Controllers;

use App\Http\Requests\JadwalPosyanduRequest\StoreJadwalPosyanduRequest;
use App\Http\Requests\JadwalPosyanduRequest\UpdateJadwalPosyanduRequest;
use App\Services\JadwalPosyanduService;
use Illuminate\Http\Request;

class JadwalPosyanduController extends Controller
{
    protected $jadwalPosyanduService;

    public function __construct(JadwalPosyanduService $jadwalPosyanduService)
    {
        $this->jadwalPosyanduService = $jadwalPosyanduService;
    }

    public function index()
    {
        if (auth()->user()->hasRole('Orang Tua')) {
            $posyandu = auth()->user()->orangtua->anak->first()->posyandu_id;
            $jadwal = $this->jadwalPosyanduService->getJadwalPosyanduByPosyanduId($posyandu);
        } else {
            $jadwal = $this->jadwalPosyanduService->getAllJadwalPosyandu();
        }
        return view('posyandu.posyandu.jadwal.index', [
            'jadwal' => $jadwal,
        ]);
    }

    public function store(StoreJadwalPosyanduRequest $request)
    {
        $this->jadwalPosyanduService->createjadwalPosyandu($request->validated());
        return redirect()->back()->with('success', 'Data Jadwal Posyandu Berhasil Ditambahkan');
    }

    public function destroy($id)
    {
        $this->jadwalPosyanduService->deletejadwalPosyandu($id);
        return redirect()->back()->with('success', 'Data Jadwal Posyandu Berhasil Dihapus');
    }


    public function update(UpdateJadwalPosyanduRequest $request, $id)
    {
        $this->jadwalPosyanduService->updatejadwalPosyandu($request->validated(), $id);

        return redirect()->back()->with([
            'success' => 'Data Jadwal Posyandu Berhasil Diubah',
        ]);
    }
}
