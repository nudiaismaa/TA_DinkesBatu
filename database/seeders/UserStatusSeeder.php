<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_statuses')->updateOrInsert(
            ['id' => 1],
            ['name' => 'Tidak Aktif']
        );

        DB::table('user_statuses')->updateOrInsert(
            ['id' => 2],
            ['name' => 'Proses Validasi']
        );

        DB::table('user_statuses')->updateOrInsert(
            ['id' => 3],
            ['name' => 'Aktif']
        );
    }
}
