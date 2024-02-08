<?php

namespace App\Interfaces;

interface WebConfigurationRepositoryInterface
{
    public function getWebConfiguration();

    public function updateWebConfiguration(array $data);
}
