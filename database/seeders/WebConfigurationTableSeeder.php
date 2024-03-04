<?php

namespace Database\Seeders;

use App\Models\WebConfiguration;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class WebConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logo = UploadedFile::fake()->image('logo.png');

        WebConfiguration::factory()->create([
            'title' => 'Griya Lima Belas',
            'description' => 'This is my website...',
            'logo' => $logo->store('assets/web-configurations', 'public'),
        ]);
    }
}
