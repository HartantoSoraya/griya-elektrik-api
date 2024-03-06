<?php

namespace App\Repositories;

use App\Interfaces\ClientRepositoryInterface;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAllClients()
    {
        $clients = Client::orderBy('name', 'asc')->get();

        return $clients;
    }

    public function getClientById(string $id)
    {
        return Client::find($id);
    }

    public function create(array $data)
    {
        $client = new Client();
        $client->name = $data['name'];
        $client->logo = $data['logo'] ? $data['logo']->store('assets/clients', 'public') : '';
        $client->url = $data['url'];
        $client->save();

        return $client;
    }

    public function update(string $id, array $data)
    {
        $client = Client::find($id);

        $client->name = $data['name'];
        $client->logo = $this->updateLogo($client->logo, $data['logo']);
        $client->url = $data['url'];
        $client->save();

        return $client;
    }

    public function delete(string $id)
    {
        return Client::find($id)->delete();
    }

    private function updateLogo($oldImage, $newImage): string
    {
        if ($oldImage) {
            Storage::delete($oldImage);
        }

        if ($newImage) {
            return $newImage->store('assets/clients', 'public');
        }

        return '';
    }
}
