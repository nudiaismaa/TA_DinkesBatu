<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelurahans')->insert([


            // Kecamatan Batu
            [
                'id' => '1',
                'kecamatan_id' => '1',
                'nama' => 'Oro-oro Ombo',
            ],
            [
                'id' => '2',
                'kecamatan_id' => '1',
                'nama' => 'Pesanggrahan',
            ],
            [
                'id' => '3',
                'kecamatan_id' => '1',
                'nama' => 'Sidomulyo',
            ],
            [
                'id' => '4',
                'kecamatan_id' => '1',
                'nama' => 'Sumberejo',
            ],
            [
                'id' => '5',
                'kecamatan_id' => '1',
                'nama' => 'Ngaglik',
            ],
            [
                'id' => '6',
                'kecamatan_id' => '1',
                'nama' => 'Sisir',
            ],
            [
                'id' => '7',
                'kecamatan_id' => '1',
                'nama' => 'Songgokerto',
            ],
            [
                'id' => '8',
                'kecamatan_id' => '1',
                'nama' => 'Temas',
            ],
            // Kecamatan Bumiaji
            [
                'id' => '9',
                'kecamatan_id' => '2',
                'nama' => 'Bulukerto',
            ],
            [
                'id' => '10',
                'kecamatan_id' => '2',
                'nama' => 'Bumiaji',
            ],
            [
                'id' => '11',
                'kecamatan_id' => '2',
                'nama' => 'Giripurno',
            ],
            [
                'id' => '12',
                'kecamatan_id' => '2',
                'nama' => 'Gunungsari',
            ],
            [
                'id' => '13',
                'kecamatan_id' => '2',
                'nama' => 'Pandanrejo',
            ],
            [
                'id' => '14',
                'kecamatan_id' => '2',
                'nama' => 'Punten',
            ],
            [
                'id' => '15',
                'kecamatan_id' => '2',
                'nama' => 'Sumber Brantas',
            ],
            [
                'id' => '16',
                'kecamatan_id' => '2',
                'nama' => 'Sumbergondo',
            ],
            [
                'id' => '17',
                'kecamatan_id' => '2',
                'nama' => 'Tulungrejo',
            ],
            // Kecamatan Junrejo
            [
                'id' => '18',
                'kecamatan_id' => '3',
                'nama' => 'Beji',
            ],
            [
                'id' => '19',
                'kecamatan_id' => '3',
                'nama' => 'Junrejo',
            ],
            [
                'id' => '20',
                'kecamatan_id' => '3',
                'nama' => 'Mojorejo',
            ],
            [
                'id' => '21',
                'kecamatan_id' => '3',
                'nama' => 'Pendem',
            ],
            [
                'id' => '22',
                'kecamatan_id' => '3',
                'nama' => 'Tlekung',
            ],
            [
                'id' => '23',
                'kecamatan_id' => '3',
                'nama' => 'Torongrejo',
            ],
            [
                'id' => '24',
                'kecamatan_id' => '3',
                'nama' => 'Dadaprejo',
            ],
        ]
        );
    }
}
