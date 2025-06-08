<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_statuses')->insert(
            [
                'id' => 1,
                'name' => 'Tidak Aktif',
            ]
        );
        DB::table('user_statuses')->insert(
            [
                'id' => 2,
                'name' => 'Proses Validasi',
            ]
        );
        DB::table('user_statuses')->insert(
            [
                'id' => 3,
                'name' => 'Aktif',
            ]
        );
    }
}
