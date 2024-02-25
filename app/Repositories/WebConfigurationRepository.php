<?php

namespace App\Repositories;

use App\Interfaces\WebConfigurationRepositoryInterface;
use App\Models\WebConfiguration;

class WebConfigurationRepository implements WebConfigurationRepositoryInterface
{
    public function getWebConfiguration()
    {
        return WebConfiguration::first();
    }

    public function updateWebConfiguration(array $data)
    {
        $webConfiguration = WebConfiguration::first();
        $webConfiguration->title = $data['title'];
        $webConfiguration->description = $data['description'];
        $webConfiguration->logo = $data['logo']->store('assets/web-configurations', 'public');
        $webConfiguration->save();

        return $webConfiguration;
    }
}
