<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => 'Administrator',
            'description' => 'Grup untuk administrator sistem'
        ]);

        Group::create([
            'name' => 'Department Coordinator',
            'description' => 'Grup untuk koordinator departemen'
        ]);

        Group::create([
            'name' => 'Sub Admin',
            'description' => 'Grup untuk koordinator angkatan'
        ]);

        Group::create([
            'name' => 'Alumni',
            'description' => 'Grup untuk alumni'
        ]);
    }
}
