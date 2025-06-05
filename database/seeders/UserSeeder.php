<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert users into the database
        $users = [
            [
                'id' => Str::uuid(),
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'user_status_id' => 3,
                'role' => 'Super Admin', // Assign this role
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Puskesmas A',
                'email' => 'puskesmasa@gmail.com',
                'password' => bcrypt('puskesmas123'),
                'user_status_id' => 3,
                'role' => 'Puskesmas', // Assign this role
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Puskesmas B',
                'email' => 'puskesmasb@gmail.com',
                'password' => bcrypt('puskesmas123'),
                'user_status_id' => 3,
                'role' => 'Puskesmas', // Assign this role
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Posyandu A',
                'email' => 'posyandua@gmail.com',
                'password' => bcrypt('posyandu123'),
                'user_status_id' => 3,
                'role' => 'Posyandu', // Assign this role
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Posyandu B',
                'email' => 'posyandub@gmail.com',
                'password' => bcrypt('posyandu123'),
                'user_status_id' => 3,
                'role' => 'Posyandu', // Assign this role
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Front Office',
                'email' => 'frontoffice@gmail.com',
                'password' => bcrypt('frontoffice123'),
                'user_status_id' => 3,
                'role' => 'Front Office', // Assign this role
            ],
            [
                'id' => Str::uuid(),
                'name' => 'KADINKES Kota Batu',
                'email' => 'kadinkes@gmail.com',
                'password' => bcrypt('kadinkes123'),
                'user_status_id' => 3,
                'role' => 'Dinkes Kota Batu', // Assign this role
            ],
            [
                'id' => Str::uuid(),
                'name' => 'KABAG Kota Batu',
                'email' => 'kabag@gmail.com',
                'password' => bcrypt('kabag123'),
                'user_status_id' => 3,
                'role' => 'Dinkes Kota Batu', // Assign this role
            ],
        ];

        foreach ($users as $userData) {
            // Create the user
            $user = User::create([
                'id' => $userData['id'],
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'user_status_id' => $userData['user_status_id'],
            ]);

            // Assign the role to the user
            $user->assignRole($userData['role']);
        }
    }
}
