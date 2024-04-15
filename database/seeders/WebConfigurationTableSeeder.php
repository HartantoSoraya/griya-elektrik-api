<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\WebConfiguration;
use Illuminate\Database\Seeder;

class WebConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageHelper = new ImageHelper();

        $logo = $imageHelper->createDummyImageWithTextSizeAndPosition(200, 200, 'center', 'center', null, 'large');

        WebConfiguration::factory()->create([
            'title' => 'Griya Lima Belas',
            'description' => 'This is my website...',
            'logo' => $logo->store('assets/web-configurations', 'public'),
        ]);
    }
}
