<?php

namespace App\Http\Controllers;

use App\Exports\AnakPemeriksaanExport;
use App\Exports\PemeriksaanAnakExport;
use App\Http\Requests\PemeriksaanRequest\StorePemeriksaanRequest;
use App\Http\Requests\PemeriksaanRequest\UpdatePemeriksaanRequest;
use App\Models\Anak;
use App\Models\StandarAntropometriLaki;
use App\Models\StandarAntropometriPerempuan;
use App\Services\AnakService;
use App\Services\ImunisasiService;
use App\Services\JenisImunisasiService;
use App\Services\PemeriksaanExportService;
use App\Services\PemeriksaanService;
use App\Services\PuskesmasService;
use App\Services\PosyanduService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PemeriksaanController extends Controller
{
    protected $pemeriksaanService, $anakService, $jenisImunisasiService, $imunisasiService, $pemeriksaanExportService, $puskesmasService, $posyanduService;

    public function __construct(PemeriksaanService $pemeriksaanService, AnakService $anakService, JenisImunisasiService $jenisImunisasiService, ImunisasiService $imunisasiService, PemeriksaanExportService $pemeriksaanExportService, PuskesmasService $puskesmasService, PosyanduService $posyanduService)
    {
        $this->pemeriksaanService = $pemeriksaanService;
        $this->anakService = $anakService;
        $this->jenisImunisasiService = $jenisImunisasiService;
        $this->imunisasiService = $imunisasiService;
        $this->pemeriksaanExportService = $pemeriksaanExportService;
        $this->puskesmasService = $puskesmasService;
        $this->posyanduService = $posyanduService;
    }

    public function index()
    {
        $anak = $this->anakService->getAllAnak();
        $puskesmas = $this->puskesmasService->getAllPuskesmas();
        $posyandu = $this->posyanduService->getAllPosyandu();
        return view('reports.index', ['anak' => $anak, 'pemeriksaan' => $this->pemeriksaanService->getAllPemeriksaan(), 'puskesmas' => $puskesmas, 'posyandus' => $posyandu]);
    }

    public function show($id)
    {
        $anak = $this->anakService->getAnakById($id);
        $pemeriksaan = $this->pemeriksaanService->getPemeriksaanByAnakId($id);
        return view('reports.detail', [
            'anak' => $anak,
            'pemeriksaan' => $pemeriksaan
        ]);
    }

    public function create()
    {
        $anak = $this->anakService->getAllAnak();
        $jenisImunisasi = $this->jenisImunisasiService->getAllJenisImunisasi();
        return view('reports.create', ['anak' => $anak, 'jenisImunisasi' => $jenisImunisasi]);
    }

    public function store(StorePemeriksaanRequest $request)
    {
        DB::beginTransaction();
        try {
            $pemeriksaanData = $request->validated();

            $pemeriksaanData['tinggi_badan'] = (float) $request->input('tinggi_badan');
            $pemeriksaanData['berat_badan'] = (float) $request->input('berat_badan');
            $pemeriksaanData['lingkar_kepala'] = (float) $request->input('lingkar_kepala');


            if (!is_null($request->tinggi_badan)) {
                $anak = $this->anakService->getAnakById($request->anak_id);
                $usiaBulan = \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now());
                $tinggi_badan = $request->tinggi_badan;

                if ($anak->jenis_kelamin === 'L') {
                    $standard = StandarAntropometriLaki::where('usia_bulan', $usiaBulan)->first();
                } else {
                    $standard = StandarAntropometriPerempuan::where('usia_bulan', $usiaBulan)->first();
                }

                if ($standard) {
                    $sd = ($standard->tb_sd_plus_2 - $standard->tb_sd_median) / 2;
                    $zscore = ($tinggi_badan - $standard->tb_sd_median) / $sd;
                    $zscore = round($zscore, 2);

                    if ($zscore < -3) {
                        $pemeriksaanData['hasil_standar'] = 0;
                    } elseif ($zscore >= -3 && $zscore < -2) {
                        $pemeriksaanData['hasil_standar'] = 1;
                    } elseif ($zscore >= -2 && $zscore <= 3) {
                        $pemeriksaanData['hasil_standar'] = 2;
                    } else {
                        $pemeriksaanData['hasil_standar'] = 3;
                    }

                    $pemeriksaanData['zscore'] = $zscore;
                }
            }

            $pemeriksaan = $this->pemeriksaanService->createPemeriksaan($pemeriksaanData);

            if ($request->status_imunisasi === 'Diberikan' && !empty($request->jenis_imunisasi)) {
                $imunisasiData = [
                    'pemeriksaan_id' => $pemeriksaan->id,
                    'status_imunisasi' => 'Diberikan',
                    'tanggal_pemberian' => now(),
                    'keterangan' => $request->keterangan ?? 'Imunisasi diberikan'
                ];

                $imunisasi = $this->imunisasiService->createImunisasi($imunisasiData);
                $imunisasi->jenis_imunisasi()->attach($request->jenis_imunisasi);
            }

            DB::commit();
            return redirect()->route('pemeriksaan.index')
                ->with('success', 'Data Pemeriksaan Berhasil Ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->pemeriksaanService->deletepemeriksaan($id);
        return redirect()->back()->with('success', 'Data Pemeriksaan Berhasil Dihapus');
    }

    public function edit($id)
    {
        $pemeriksaan = $this->pemeriksaanService->getPemeriksaanById($id);
        $jenisImunisasi = $this->jenisImunisasiService->getAllJenisImunisasi();
        return view('reports.edit', ['jenisImunisasi' => $jenisImunisasi, 'pemeriksaan' => $pemeriksaan]);
    }

    public function update(UpdatePemeriksaanRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $pemeriksaanData = $request->validated();

            $pemeriksaanData['tinggi_badan'] = (float) $request->input('tinggi_badan');
            $pemeriksaanData['berat_badan'] = (float) $request->input('berat_badan');
            $pemeriksaanData['lingkar_kepala'] = (float) $request->input('lingkar_kepala');

            $currentPemeriksaan = $this->pemeriksaanService->getPemeriksaanById($id);

            if (
                !is_null($request->tinggi_badan) &&
                $currentPemeriksaan->tinggi_badan != $request->tinggi_badan
            ) {

                $anak = $this->anakService->getAnakById($currentPemeriksaan->anak_id);
                $usiaBulan = \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now());
                $tinggi_badan = $request->tinggi_badan;

                if ($anak->jenis_kelamin === 'L') {
                    $standard = StandarAntropometriLaki::where('usia_bulan', $usiaBulan)->first();
                } else {
                    $standard = StandarAntropometriPerempuan::where('usia_bulan', $usiaBulan)->first();
                }

                if ($standard) {
                    $sd = ($standard->tb_sd_plus_2 - $standard->tb_sd_median) / 2;
                    $zscore = ($tinggi_badan - $standard->tb_sd_median) / $sd;
                    $zscore = round($zscore, 2);

                    if ($zscore < -3) {
                        $pemeriksaanData['hasil_standar'] = 0;
                    } elseif ($zscore >= -3 && $zscore < -2) {
                        $pemeriksaanData['hasil_standar'] = 1;
                    } elseif ($zscore >= -2 && $zscore <= 3) {
                        $pemeriksaanData['hasil_standar'] = 2;
                    } else {
                        $pemeriksaanData['hasil_standar'] = 3;
                    }

                    $pemeriksaanData['zscore'] = $zscore;
                }
            }

            $this->pemeriksaanService->updatePemeriksaan($pemeriksaanData, $id);

            if ($request->has('status_imunisasi')) {
                if ($request->status_imunisasi === 'Diberikan' && !empty($request->jenis_imunisasi)) {
                    $imunisasiData = [
                        'pemeriksaan_id' => $id,
                        'status_imunisasi' => 'Diberikan',
                        'tanggal_pemberian' => now(),
                        'keterangan' => $request->keterangan ?? 'Imunisasi diberikan'
                    ];

                    if ($currentPemeriksaan->imunisasi) {
                        $imunisasi = $this->imunisasiService->updateImunisasi(
                            $imunisasiData,
                            $currentPemeriksaan->imunisasi->id
                        );
                        $imunisasi->jenis_imunisasi()->sync([$request->jenis_imunisasi]);
                    } else {
                        $imunisasi = $this->imunisasiService->createImunisasi($imunisasiData);
                        $imunisasi->jenis_imunisasi()->attach($request->jenis_imunisasi);
                    }
                } elseif ($currentPemeriksaan->imunisasi) {
                    $this->imunisasiService->deleteImunisasi($currentPemeriksaan->imunisasi->id);
                }
            }

            DB::commit();
            return redirect()->route('pemeriksaan.index')
                ->with('success', 'Data Pemeriksaan Berhasil Diubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function exportExcel($id)
    {
        $data = $this->pemeriksaanExportService->getPemeriksaanByAnakId($id);

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan untuk anak ini.');
        }

        return Excel::download(new PemeriksaanAnakExport($data), 'pemeriksaan-anak-' . $id . '.xlsx');
    }

    public function showFromAnak($id)
    {
        $anak = $this->anakService->getAnakById($id);
        $pemeriksaan = $this->pemeriksaanService->getPemeriksaanByAnakId($id);
        return view('orangtua.anak.detailReports', [
            'anak' => $anak,
            'pemeriksaan' => $pemeriksaan
        ]);
    }

    public function exportExcelPemeriksaan(Request $request)
    {
        $user = auth()->user();
        $fileName = 'laporan-perkembangan-anak.xlsx';
        $extraInfo = '';

        if ($user->hasRole('Super Admin') || $user->hasRole('Dinkes Kota Batu')) {
            $query = Anak::query()->with(['pemeriksaan.imunisasi.jenis_imunisasi', 'posyandu.puskesmas']);

            if ($request->has('puskesmas_id')) {
                $puskesmas = $this->puskesmasService->getPuskesmasById($request->puskesmas_id);
                $query->whereHas('posyandu', function ($q) use ($request) {
                    $q->where('puskesmas_id', $request->puskesmas_id);
                });
                $extraInfo = $puskesmas ? 'Puskesmas: ' . $puskesmas->nama_puskesmas : 'Semua Data';
            } else {
                $extraInfo = 'Semua Data';
            }

            $anak = $query->get();
        } elseif ($user->hasRole('Puskesmas')) {
            $puskesmas = $user->puskesmas->first();
            $puskesmasId = $puskesmas->id ?? null;

            $query = Anak::whereHas('posyandu', function ($q) use ($puskesmasId) {
                $q->where('puskesmas_id', $puskesmasId);
            })->with(['pemeriksaan.imunisasi.jenis_imunisasi', 'posyandu']);

            if ($request->has('posyandu_id')) {
                $posyandu = $this->posyanduService->getPosyanduById($request->posyandu_id);
                $query->where('posyandu_id', $request->posyandu_id);
                $extraInfo = $posyandu ? 'Posyandu: ' . $posyandu->nama_posyandu : '';
                $fileName = 'laporan-anak-posyandu-' . ($posyandu ? str_replace(' ', '_', strtolower($posyandu->nama_posyandu)) : 'unknown') . '.xlsx';
            } else {
                $extraInfo = $puskesmas ? 'Puskesmas: ' . $puskesmas->nama_puskesmas : '';
                $fileName = 'laporan-anak-puskesmas-' . ($puskesmas ? str_replace(' ', '_', strtolower($puskesmas->nama_puskesmas)) : 'unknown') . '.xlsx';
            }

            $anak = $query->get();
        } elseif ($user->hasRole('Posyandu')) {
            $posyandu = $user->posyandu->first();
            $posyanduId = $posyandu->id ?? null;
            $anak = Anak::where('posyandu_id', $posyanduId)
                ->with(['pemeriksaan.imunisasi.jenis_imunisasi', 'posyandu'])->get();
            $extraInfo = $posyandu ? 'Posyandu: ' . $posyandu->nama_posyandu : '';
            $fileName = 'laporan-anak-posyandu-' . ($posyandu ? str_replace(' ', '_', strtolower($posyandu->nama_posyandu)) : 'unknown') . '.xlsx';
        } elseif ($user->hasRole('Orang Tua')) {
            $orangtua = $user->orangtua->first();
            $orangtuaId = $orangtua->id ?? null;
            $anak = Anak::where('orangtua_id', $orangtuaId)
                ->with(['pemeriksaan.imunisasi.jenis_imunisasi', 'posyandu'])->get();
            $extraInfo = $orangtua ? 'Orang Tua: ' . $orangtua->nama : '';
            $fileName = 'laporan-anak-orangtua-' . ($orangtua ? str_replace(' ', '_', strtolower($orangtua->nama)) : 'unknown') . '.xlsx';
        } else {
            $anak = collect();
            $extraInfo = '';
        }

        return Excel::download(
            new AnakPemeriksaanExport($anak, $extraInfo),
            $fileName
        );
    }
}
