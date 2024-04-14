<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageHelper = new ImageHelper();

        for ($i = 0; $i < mt_rand(5, 20); $i++) {
            $logo = $imageHelper->createDummyImageWithTextSizeAndPosition(200, 200, 'center', 'center', 'random', 'large');
            Client::factory()->create([
                'logo' => $logo->store('assets/clients', 'public'),
            ]);
        }
    }
}
