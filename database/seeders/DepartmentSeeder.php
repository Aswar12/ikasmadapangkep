<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Pendidikan & Pengembangan Karir',
                'slug' => 'pendidikan-pengembangan-karir',
                'description' => 'Departemen yang bertanggung jawab untuk pengembangan pendidikan dan karir alumni',
                'is_active' => true,
            ],
            [
                'name' => 'Humas & Pengembangan Jaringan',
                'slug' => 'humas-pengembangan-jaringan',
                'description' => 'Departemen yang mengelola hubungan masyarakat dan pengembangan jaringan alumni',
                'is_active' => true,
            ],
            [
                'name' => 'Agama, Budaya & Kemasyarakatan',
                'slug' => 'agama-budaya-kemasyarakatan',
                'description' => 'Departemen yang mengelola kegiatan keagamaan, budaya, dan kemasyarakatan',
                'is_active' => true,
            ],
            [
                'name' => 'Pembinaan Aparatur Organisasi',
                'slug' => 'pembinaan-aparatur-organisasi',
                'description' => 'Departemen yang bertanggung jawab untuk pembinaan dan pengembangan organisasi',
                'is_active' => true,
            ],
            [
                'name' => 'Keuangan & Kewirausahaan',
                'slug' => 'keuangan-kewirausahaan',
                'description' => 'Departemen yang mengelola keuangan organisasi dan pengembangan kewirausahaan alumni',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert(array_merge($department, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
