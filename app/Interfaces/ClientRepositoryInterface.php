<?php

namespace App\Interfaces;

interface ClientRepositoryInterface
{
    public function getAllClients();

    public function getClientById(string $id);

    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);
}
