<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(WebConfigurationTableSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductBrandSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(BranchTableSeeder::class);
        $this->call(ClientSeeder::class);
    }
}
