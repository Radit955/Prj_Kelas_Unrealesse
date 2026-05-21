<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin SMK',
            'email' => 'admin@smk.com',
            'password' => bcrypt('password'),
            'nis_nip' => 'ADM001',
        ]);
        $admin->assignRole('admin');

        // Wali Kelas
        $wali = User::create([
            'name' => 'Wali Kelas XI TKRO',
            'email' => 'wali@smk.com',
            'password' => bcrypt('password'),
            'nis_nip' => 'WALI001',
        ]);
        $wali->assignRole('wali_kelas');

        // Guru
        $guru = User::create([
            'name' => 'Guru Informatika',
            'email' => 'guru@smk.com',
            'password' => bcrypt('password'),
            'nis_nip' => 'GURU001',
        ]);
        $guru->assignRole('guru');
        Teacher::create([
            'user_id' => $guru->id,
            'nip' => 'GURU001',
            'subject' => 'Informatika',
        ]);

        // Ketua Kelas
        $ketua = User::create([
            'name' => 'Ketua Kelas',
            'email' => 'ketua@smk.com',
            'password' => bcrypt('password'),
            'nis_nip' => '12345',
        ]);
        $ketua->assignRole('ketua_kelas');
        Student::create([
            'user_id' => $ketua->id,
            'nis' => '12345',
            'class' => 'XI TKRO',
        ]);

        // Murid
        $murid = User::create([
            'name' => 'Murid Sample',
            'email' => 'murid@smk.com',
            'password' => bcrypt('password'),
            'nis_nip' => '67890',
        ]);
        $murid->assignRole('murid');
        Student::create([
            'user_id' => $murid->id,
            'nis' => '67890',
            'class' => 'XI TKRO',
        ]);
    }
}
