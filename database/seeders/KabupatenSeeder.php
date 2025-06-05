<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kabupatens')->insert(
            [
                'id' => '1',
                'provinsi_id' => '1',
                'nama' => 'Batu',
            ],
        );
    }
}
