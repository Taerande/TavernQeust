<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;


class NaverLoginProvider
{
    private $clinet_id;
    private $clinet_secret;
    private $token_url = 'https://nid.naver.com/oauth2.0/token';
    private $profile_url = 'https://openapi.naver.com/v1/nid/me';
    private $grant_type = 'authorization_code';
    private $code;
    private $state;
    private $redirect_uri;

    function __construct($_code, $_state)
    {
        $this->redirect_uri = $_ENV["APP_FRONTEND_URL"] . '/login/naver';
        $this->clinet_id = $_ENV["NAVER_CLIENT_ID"];
        $this->clinet_secret = $_ENV["NAVER_CLIENT_SECRET"];
        $this->code = $_code;
        $this->state = $_state;
    }
    private function getAccessToken()
    {
        $resp = Http::get($this->token_url, [
            'client_id' => $this->clinet_id,
            'client_secret' => $this->clinet_secret,
            'grant_type' => $this->grant_type,
            'code' => $this->code,
            'state' => $this->state,
        ]);
        if ($resp->successful()) {
            return $resp->json();
        } else {
            return ['error' => 'error'];
        }
    }
    public function getUserInfo()
    {
        $token_data = $this->getAccessToken();
        $resp = Http::withToken($token_data['access_token'])->get($this->profile_url);

        if ($resp->successful()) {
            $result = $resp->json()['response'];
            return [
                'status' => 'success',
                'email' => $result['email'],
                'name' => $result['nickname'],
                'photoUrl' => $result['profile_image'],
            ];
        } else {
            return ['status' => 'error'];
        }
    }
}
