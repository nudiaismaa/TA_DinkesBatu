<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JenisImunisasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_imunisasis')->insert([
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'Hepatitis B',
                'deskripsi' => 'Mencegah infeksi virus hepatitis B yang dapat menyebabkan kerusakan hati',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'DPT',
                'deskripsi' => 'Mencegah penyakit Difteri, Pertusis (batuk rejan), dan Tetanus',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'BCG',
                'deskripsi' => 'Mencegah penyakit tuberkulosis (TBC) yang menyerang paru-paru',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'Polio',
                'deskripsi' => 'Mencegah virus polio yang dapat menyebabkan kelumpuhan',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'PCV',
                'deskripsi' => 'Mencegah infeksi pneumokokus yang dapat menyebabkan pneumonia dan meningitis',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'Rotavirus',
                'deskripsi' => 'Mencegah infeksi rotavirus yang menyebabkan diare parah pada bayi dan anak',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'Measles Rubella',
                'deskripsi' => 'Mencegah penyakit campak dan rubella yang dapat menyebabkan komplikasi serius',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'Campak',
                'deskripsi' => 'Mencegah infeksi virus campak yang dapat menyebabkan demam dan ruam',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'HiB',
                'deskripsi' => 'Mencegah infeksi Haemophilus influenzae tipe B yang dapat menyebabkan meningitis',
            ],
            [
                'id' => Str::uuid(),
                'nama_imunisasi' => 'Influenza',
                'deskripsi' => 'Mencegah infeksi virus influenza yang menyebabkan flu dan komplikasinya',
            ],
        ]);
    }
}
