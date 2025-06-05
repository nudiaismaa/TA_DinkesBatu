<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserStatusSeeder::class,
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            RoleSeeder::class,
            JenisImunisasiSeeder::class,
            StandarAntopometriLakiSeeder::class,
            StandarAntopometriPerempuanSeeder::class,
            UserSeeder::class,
        ]);
    }
}
