<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ModmeService
{
    private string $token;
    public string $modme_url;

    public function __construct()
    {
        $this->modme_url = config('app.modme_API_URL');
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    // Modme-da berilgan tokenni tekshirish
    public function checkToken(string $token): mixed
    {
        try {
            $client = new Client();
            $post = $client->get($this->modme_url."/v2/token/me", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ]
            ]);
            return json_decode($post->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    // Modme-da shu token bo'yicha kompaniyaga filiallarini tekshirish
    public function checkCompany($token)
    {
        try {
            $client = new Client();
            $post = $client->get($this->modme_url."/v2/branches", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ]
            ]);
            return json_decode($post->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        }
    }

    // Modme-da filail guruhlarni olish f-yasi
    public function checkGroup($branch_id, $token)
    {
        try{
            $client = new Client();
            $response = $client->get($this->modme_url."/v2/groups",[
                'query' => [
                    'branch_id' => $branch_id,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'

                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        }catch (GuzzleException $e) {
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        }

    }
}

