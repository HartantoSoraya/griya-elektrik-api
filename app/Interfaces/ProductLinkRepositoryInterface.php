<?php

namespace App\Interfaces;

interface ProductLinkRepositoryInterface
{
    public function getAllProductLinks();

    public function getProductLinkById(string $id);

    public function createProductLink(array $data);

    public function updateProductLink(string $id, array $data);

    public function deleteProductLink(string $id);
}
