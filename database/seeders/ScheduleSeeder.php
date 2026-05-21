<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            ['day' => 'SENIN', 'lesson_code' => 'INF.22', 'lesson_name' => 'Informatika', 'teacher_code' => '22', 'start_time' => '07:00', 'end_time' => '10:00', 'class_name' => 'XI TKRO'],
            ['day' => 'SENIN', 'lesson_code' => 'IPAS.04', 'lesson_name' => 'Ilmu Pengetahuan Alam dan Sosial', 'teacher_code' => '04', 'start_time' => '10:00', 'end_time' => '13:00', 'class_name' => 'XI TKRO'],
            ['day' => 'SENIN', 'lesson_code' => 'THF.17', 'lesson_name' => 'Tata Hidup', 'teacher_code' => '17', 'start_time' => '13:00', 'end_time' => '14:00', 'class_name' => 'XI TKRO'],
            ['day' => 'SENIN', 'lesson_code' => 'B.INDO.07', 'lesson_name' => 'Bahasa Indonesia', 'teacher_code' => '07', 'start_time' => '14:00', 'end_time' => '17:00', 'class_name' => 'XI TKRO'],
            ['day' => 'SELASA', 'lesson_code' => 'PJOK.01', 'lesson_name' => 'Pendidikan Jasmani Olahraga dan Kesehatan', 'teacher_code' => '01', 'start_time' => '07:00', 'end_time' => '11:00', 'class_name' => 'XI TKRO'],
            ['day' => 'SELASA', 'lesson_code' => 'PAI.20', 'lesson_name' => 'Pendidikan Agama Islam', 'teacher_code' => '20', 'start_time' => '07:00', 'end_time' => '11:00', 'class_name' => 'XI TKRO'],
            ['day' => 'SELASA', 'lesson_code' => 'MTK.17', 'lesson_name' => 'Matematika', 'teacher_code' => '17', 'start_time' => '11:00', 'end_time' => '13:00', 'class_name' => 'XI TKRO'],
            ['day' => 'SELASA', 'lesson_code' => 'DK.15', 'lesson_name' => 'Dasar Kejuruan', 'teacher_code' => '15', 'start_time' => '13:00', 'end_time' => '16:00', 'class_name' => 'XI TKRO'],
            ['day' => 'SELASA', 'lesson_code' => 'SJH.04', 'lesson_name' => 'Sejarah', 'teacher_code' => '04', 'start_time' => '13:00', 'end_time' => '16:00', 'class_name' => 'XI TKRO'],
            ['day' => 'RABU', 'lesson_code' => 'BK.16', 'lesson_name' => 'Bimbingan Konseling', 'teacher_code' => '16', 'start_time' => '07:00', 'end_time' => '11:00', 'class_name' => 'XI TKRO'],
            ['day' => 'RABU', 'lesson_code' => 'DK.05', 'lesson_name' => 'Dasar Kejuruan', 'teacher_code' => '05', 'start_time' => '07:00', 'end_time' => '11:00', 'class_name' => 'XI TKRO'],
            ['day' => 'RABU', 'lesson_code' => 'DK.15', 'lesson_name' => 'Dasar Kejuruan', 'teacher_code' => '15', 'start_time' => '11:00', 'end_time' => '13:00', 'class_name' => 'XI TKRO'],
            ['day' => 'RABU', 'lesson_code' => 'PP.14', 'lesson_name' => 'Produktif Produktif', 'teacher_code' => '14', 'start_time' => '13:00', 'end_time' => '16:00', 'class_name' => 'XI TKRO'],
            ['day' => 'RABU', 'lesson_code' => 'B.SUN.13', 'lesson_name' => 'Bahasa Sunda', 'teacher_code' => '13', 'start_time' => '13:00', 'end_time' => '16:00', 'class_name' => 'XI TKRO'],
            ['day' => 'KAMIS', 'lesson_code' => 'KTR.02', 'lesson_name' => 'Kewirausahaan', 'teacher_code' => '02', 'start_time' => '07:00', 'end_time' => '11:00', 'class_name' => 'XI TKRO'],
            ['day' => 'KAMIS', 'lesson_code' => 'IPAS.04', 'lesson_name' => 'Ilmu Pengetahuan Alam dan Sosial', 'teacher_code' => '04', 'start_time' => '07:00', 'end_time' => '11:00', 'class_name' => 'XI TKRO'],
            ['day' => 'KAMIS', 'lesson_code' => 'B.ING.14', 'lesson_name' => 'Bahasa Inggris', 'teacher_code' => '14', 'start_time' => '11:00', 'end_time' => '13:00', 'class_name' => 'XI TKRO'],
            ['day' => 'KAMIS', 'lesson_code' => 'B.ARAB.23', 'lesson_name' => 'Bahasa Arab', 'teacher_code' => '23', 'start_time' => '13:00', 'end_time' => '16:00', 'class_name' => 'XI TKRO'],
            ['day' => 'KAMIS', 'lesson_code' => 'KOD.05', 'lesson_name' => 'Koding', 'teacher_code' => '05', 'start_time' => '13:00', 'end_time' => '16:00', 'class_name' => 'XI TKRO'],
            ['day' => 'JUMAT', 'lesson_code' => 'SHOLAT DUHA/LITERASI', 'lesson_name' => 'Sholat Duha/Literasi', 'teacher_code' => '', 'start_time' => '07:00', 'end_time' => '08:00', 'class_name' => 'XI TKRO'],
            ['day' => 'JUMAT', 'lesson_code' => 'TRB.02', 'lesson_name' => 'Tari dan Musik', 'teacher_code' => '02', 'start_time' => '08:00', 'end_time' => '11:00', 'class_name' => 'XI TKRO'],
            ['day' => 'JUMAT', 'lesson_code' => 'KOK.20', 'lesson_name' => 'Koki', 'teacher_code' => '20', 'start_time' => '11:00', 'end_time' => '13:00', 'class_name' => 'XI TKRO'],
        ];

        foreach ($schedules as $schedule) {
            \App\Models\Schedule::create($schedule);
        }
    }
}
