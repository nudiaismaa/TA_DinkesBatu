<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view dashboard',
            'manage users',
            'manage puskesmas',
            'manage posyandu',
            'manage orangtua',
            'manage anak',
            'manage jadwal posyandu',
            'create pemeriksaan',
            'edit pemeriksaan',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['id' => Str::uuid()->toString(), 'name' => $permission]);
        }

        $roles = [
            'Orang Tua' => ['view dashboard', 'manage users', 'manage settings'],
            'Puskesmas' => ['view dashboard', 'manage posyandu'],
            'Posyandu' => [
                'view dashboard',
                'manage orangtua',
                'manage anak',
                'manage jadwal posyandu',
                'create pemeriksaan',
                'edit pemeriksaan',
            ],
            'Super Admin' => ['view dashboard'],
            'Front Office' => ['view dashboard', 'manage puskesmas', 'manage posyandu'],
            'Dinkes Kota Batu' => ['view dashboard'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['id' => Str::uuid()->toString(), 'name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
