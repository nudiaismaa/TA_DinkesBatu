<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kecamatans')->insert(
            [
                [
                    'id' => '1',
                    'kabupaten_id' => '1',
                    'nama' => 'Batu',
                ],
                [
                    'id' => '2',
                    'kabupaten_id' => '1',
                    'nama' => 'Bumiaji',
                ],
                [
                    'id' => '3',
                    'kabupaten_id' => '1',
                    'nama' => 'Junrejo',
                ],
            ]
        );
    }
}
