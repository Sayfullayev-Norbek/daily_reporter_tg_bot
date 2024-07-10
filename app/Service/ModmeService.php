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
            return $e->getMessage();
        }
    }

    // Modme-da filail guruhlarni olish f-yasi
    public function getGroups($branch_id, $token, $i)
    {
        try{
            $client = new Client();
            $response = $client->get($this->modme_url."/v2/groups",[
                'query' => [
                    'branch_id' => $branch_id,
                    'per_page' => 3,
                    'page' => $i
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        }catch (GuzzleException $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }

    }

    // Modme-da Guruhda keldi kelmadi f-ya
    public function getAttendanes($token, $branch_id, $group_id, $to_from){
        try{
            $client = new Client();
            $response = $client->get($this->modme_url."/v2/attendances",[
                'query' => [
                    'branch_id' => $branch_id,
                    'group_id' => $group_id,
                    'from' => $to_from,
                    'to' => $to_from,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        }catch(GuzzleException $e){
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
}

