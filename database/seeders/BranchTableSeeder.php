<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::factory()->create([
            'code' => 'B001',
            'name' => 'KC. Purbalingga',
            'map_url' => '',
            'iframe_map' => '',
            'address' => 'Jl. Ahmad Yani No. 86 ( Depan Taman Makam Pahlawan )',
            'city' => 'Purbalingga',
            'email' => '',
            'phone' => '0812 8434 5301',
            'facebook' => '',
            'instagram' => '',
            'youtube' => '',
            'sort' => 1,
            'is_main' => false,
            'is_active' => true,
        ]);

        Branch::factory()->create([
            'code' => 'B002',
            'name' => 'KC. Purwokerto',
            'map_url' => '',
            'iframe_map' => '',
            'address' => 'Komplek Pertokoan Kebon Dalem Blok A-17 dan A-18',
            'city' => 'Purwokerto',
            'email' => '',
            'phone' => '0281 7782456 / 0812 8434 5301',
            'facebook' => '',
            'instagram' => '',
            'youtube' => '',
            'sort' => 2,
            'is_main' => true,
            'is_active' => true,
        ]);
    }
}
