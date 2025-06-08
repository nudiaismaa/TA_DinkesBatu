<?php

namespace App\Exports;

use App\Models\Pemeriksaan;
use Maatwebsite\Excel\Excel; // Untuk facade
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PemeriksaanAnakExport implements FromCollection, WithHeadings
{
    protected $pemeriksaan;

    public function __construct($pemeriksaan)
    {
        $this->pemeriksaan = $pemeriksaan;
    }

    public function collection()
    {
        return $this->pemeriksaan->map(function ($item) {
            $anak = $item->anak;
            $orangtua = $anak->orangtua;
            $kelurahan = $anak->kelurahan;
            $kecamatan = $kelurahan?->kecamatan;
            $kabupaten = $kecamatan?->kabupaten;
            $provinsi = $kabupaten?->provinsi;
            $puskesmas = $anak->posyandu?->puskesmas;
            return [
                $anak->anak_ke,
                "" . $anak->nik,
                $anak->nama,
                $anak->tanggal_lahir,
                $anak->jenis_kelamin,
                $anak->berat_badan_saat_lahir,
                $item->berat_badan,
                $item->tinggi_badan,
                $item->lingkar_kepala,
                $orangtua?->user?->name,
                $orangtua->nik,
                $orangtua->nomor_hp,
                $provinsi?->nama ?? '',
                $kabupaten?->nama ?? '',
                $kecamatan?->nama ?? '',
                $kelurahan?->nama ?? '',
                $puskesmas?->nama_puskesmas ?? '',
                $anak->alamat,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Anak ke',
            'NIK',
            'Nama',
            'Tgl. Lahir',
            'Jenis Kelamin',
            'Berat Badan Saat Lahir',
            'Berat Badan Saat Periksa',
            'Tinggi Badan Saat Periksa',
            'Lingkar Kepala Saat Periksa',
            'Nama Orangtua',
            'NIK Orangtua',
            'Telp/No Hp Orangtua',
            'Prov',
            'Kabupaten/Kota',
            'Kecamatan',
            'Desa/Kelurahan',
            'Puskesmas',
            'Alamat Lengkap',
        ];
    }
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,           
            'B' => NumberFormat::FORMAT_TEXT,             
            'C' => NumberFormat::FORMAT_TEXT,             
            'D' => NumberFormat::FORMAT_TEXT,             
            'E' => NumberFormat::FORMAT_TEXT,        
            'F' => NumberFormat::FORMAT_NUMBER_00,        
            'G' => NumberFormat::FORMAT_NUMBER_00,        
            'H' => NumberFormat::FORMAT_NUMBER_00,
            'I' => NumberFormat::FORMAT_NUMBER,           
            'J' => NumberFormat::FORMAT_TEXT,             
            'K' => NumberFormat::FORMAT_TEXT,             
            'L' => NumberFormat::FORMAT_TEXT,             
            'M' => NumberFormat::FORMAT_TEXT,        
            'N' => NumberFormat::FORMAT_TEXT,        
            'O' => NumberFormat::FORMAT_TEXT,        
            'P' => NumberFormat::FORMAT_TEXT,        
        ];
    }
}