<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'Pendidikan & Pengembangan Karir',
            'description' => 'Departemen yang bertanggung jawab untuk pengembangan karir dan pendidikan alumni',
            'coordinator_id' => 2, // Koordinator Pendidikan
        ]);

        Department::create([
            'name' => 'Humas & Pengembangan Jaringan',
            'description' => 'Departemen yang bertanggung jawab untuk hubungan masyarakat dan pengembangan jaringan alumni',
        ]);

        Department::create([
            'name' => 'Agama, Budaya & Kemasyarakatan',
            'description' => 'Departemen yang bertanggung jawab untuk kegiatan agama, budaya, dan kemasyarakatan',
        ]);

        Department::create([
            'name' => 'Pembinaan Aparatur Organisasi',
            'description' => 'Departemen yang bertanggung jawab untuk pembinaan struktur organisasi',
        ]);

        Department::create([
            'name' => 'Keuangan & Kewirausahaan',
            'description' => 'Departemen yang bertanggung jawab untuk pengelolaan keuangan dan kewirausahaan',
        ]);
    }
}
