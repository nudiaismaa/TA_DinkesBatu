<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnakRequest\MovePosyanduRequest;
use App\Http\Requests\AnakRequest\StoreAnakRequest;
use App\Http\Requests\AnakRequest\UpdateAnakRequest;
use App\Models\Posyandu;
use App\Services\AnakService;
use Spatie\Permission\Traits\HasRoles;
use App\Services\PosyanduService;
use Illuminate\Support\Facades\DB;

class AnakController extends Controller
{
    protected $anakService, $posyanduService;

    public function __construct(AnakService $anakService, PosyanduService $posyanduService)
    {
        $this->anakService = $anakService;
        $this->posyanduService = $posyanduService;
    }

    public function show()
    {
        $anak = $this->anakService->getAnakByOrangTuaId(auth()->user()->orangtua->id);
        $posyandu = $this->posyanduService->getAllPosyandu();
        return view('orangtua.anak.show', compact('anak', 'posyandu'));
    }

    public function index()
    {

        if (auth()->user()->hasRole('Puskesmas')) {
            $userPuskesmas = DB::table('user_puskesmas')
                ->where('user_id', auth()->id())
                ->first();

            $anak = $this->anakService->getAnakByPuskesmas($userPuskesmas->puskesmas_id);
            $posyandus = Posyandu::where('puskesmas_id', $userPuskesmas->puskesmas_id)->get();
            return view('orangtua.anak.show', ['anak' => $anak,  'posyandus' => $posyandus]);
        } elseif (auth()->user()->hasRole('Posyandu')) {
            $posyanduId = auth()->user()->posyandu->first()->id; // Get first Posyandu ID
            $anak = $this->anakService->getAnakByPosyandu($posyanduId);
            return view('orangtua.anak.show', ['anak' => $anak]);
        } elseif (auth()->user()->hasRole('Orang Tua')) {
            $anak = $this->anakService->getAnakByOrangTuaId(auth()->user()->orangtua->id);
        } else {
            $anak = $this->anakService->getAllAnak();
        }
        return view('orangtua.anak.index', ['anak' => $anak]);
    }
    public function store(StoreAnakRequest $request)
    {
        try {
            $this->anakService->createAnak($request->validated());
            return redirect()->back()->with('success', 'Anak Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(UpdateAnakRequest $request, $id)
    {
        $this->anakService->updateAnak($request->validated(), $id);

        return redirect()->back()->with([
            'success' => 'Data Anak Berhasil Diubah',
        ]);
    }

    public function destroy($id)
    {
        $this->anakService->deleteAnak($id);
        return redirect()->back()->with('success', 'Anak Berhasil Dihapus');
    }

    public function movePosyandu(MovePosyanduRequest $request)
    {
        try {
            $this->anakService->movePosyandu($request->validated());
            return redirect()->back()->with('success', 'Anak berhasil dipindahkan ke posyandu baru');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memindahkan anak: ' . $e->getMessage());
        }
    }

    public function toggleActive($id)
    {
        $this->anakService->toggleAnakActive($id);
        return redirect()->back()->with('success', 'Status Anak Berhasil Diubah');
    }
}
