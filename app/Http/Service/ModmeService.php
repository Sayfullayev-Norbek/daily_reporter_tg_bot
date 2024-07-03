<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

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

    // Modmeda shu tokendagi Client bor yuqligini tekshirish!
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

    // Shu tokenni filaillari bormi yuqmi shunga
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

}
