<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'wali_kelas']);
        Role::create(['name' => 'guru']);
        Role::create(['name' => 'guru_piket']);
        Role::create(['name' => 'ketua_kelas']);
        Role::create(['name' => 'wakil_kelas']);
        Role::create(['name' => 'seksi_kelas']);
        Role::create(['name' => 'murid']);
    }
}
