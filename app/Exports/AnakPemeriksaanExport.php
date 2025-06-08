<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class AnakPemeriksaanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $anak;
    protected $extraInfo;

    public function __construct($anak, $extraInfo)
    {
        $this->anak = $anak;
        $this->extraInfo = $extraInfo;
    }

    public function collection()
    {
        return $this->anak;
    }

    public function headings(): array
    {
        return [
            'Nama Anak',
            'NIK',
            'Tanggal Lahir',
            'Usia (Bulan)',
            'Jenis Kelamin',
            'Alamat',
            'Posyandu',
            'Tanggal Pemeriksaan',
            'Berat Badan (kg)',
            'Tinggi Badan (cm)',
            'Lingkar Kepala (cm)',
            'Z-Score',
            'Status Pertumbuhan',
            'Catatan Pemeriksaan',
            'Status Imunisasi',
            'Jenis Imunisasi',
        ];

        if ($this->extraInfo) {
            return [$this->extraInfo] + $mainHeadings;
        }
        return $mainHeadings;
    }

    public function map($anak): array
    {

        $pemeriksaanData = [];

        if ($anak->pemeriksaan->isEmpty()) {
            return [[
                $anak->nama,
                $anak->nik,
                $anak->tanggal_lahir,
                Carbon::parse($anak->tanggal_lahir)->diffInMonths(Carbon::now()),
                $anak->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan',
                $anak->alamat,
                $anak->posyandu->nama_posyandu,
                '-', // tanggal pemeriksaan
                '-', // berat badan
                '-', // tinggi badan
                '-', // lingkar kepala
                '-', // zscore
                '-', // status pertumbuhan
                '-', // catatan pemeriksaan
                'Belum Diperiksa', // status imunisasi
                '-', // jenis imunisasi
            ]];
        }
        foreach ($anak->pemeriksaan as $pemeriksaan) {
            $statusPertumbuhan = match ($pemeriksaan->hasil_standar) {
                0 => 'Sangat Pendek',
                1 => 'Pendek',
                2 => 'Normal',
                3 => 'Tinggi',
                default => '-'
            };

            $jenisImunisasi = [];
            if ($pemeriksaan->imunisasi) {
                foreach ($pemeriksaan->imunisasi->jenis_imunisasi as $jenis) {
                    $jenisImunisasi[] = $jenis->nama_imunisasi;
                }
            }

            $pemeriksaanData[] = [
                $anak->nama,
                $anak->nik,
                $anak->tanggal_lahir,
                Carbon::parse($anak->tanggal_lahir)->diffInMonths(Carbon::now()),
                $anak->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan',
                $anak->alamat,
                $anak->posyandu->nama_posyandu ?? '-',
                $pemeriksaan->tanggal_pemeriksaan ?? '-',
                $pemeriksaan->berat_badan ?? '-',
                $pemeriksaan->tinggi_badan ?? '-',
                $pemeriksaan->lingkar_kepala ?? '-',
                $pemeriksaan->zscore ?? '-',
                $statusPertumbuhan,
                $pemeriksaan->catatan_pemeriksaan ?? '-',
                $pemeriksaan->imunisasi ? $pemeriksaan->imunisasi->status_imunisasi : 'Belum Diberikan',
                !empty($jenisImunisasi) ? implode(', ', $jenisImunisasi) : '-'
            ];
        }

        return $pemeriksaanData;
    }
}
