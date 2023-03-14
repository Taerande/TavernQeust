<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;


class KakaoLoginProvider
{
    private $client_id;
    private $client_secret;
    private $token_url = 'https://kauth.kakao.com/oauth/token';
    private $profile_url = 'https://kapi.kakao.com/v2/user/me';
    private $grant_type = 'authorization_code';
    private $code;
    private $state;
    private $redirect_uri;

    function __construct($_code, $_state)
    {
        $this->redirect_uri = $_ENV["APP_FRONTEND_URL"] . '/login/kakao';
        $this->client_id = $_ENV["KAKAO_CLIENT_ID"];
        $this->client_secret = $_ENV["KAKAO_CLIENT_SECRET"];
        $this->code = $_code;
        $this->state = $_state;
    }
    public function getAccessToken()
    {
        $resp = Http::asForm()->post($this->token_url, [
            'grant_type' => $this->grant_type,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
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
            $result = $resp->json()['kakao_account'];
            return [
                'status' => 'success',
                'email' => $result['email'],
                'name' => $result['profile']['nickname'],
                'photoUrl' => $result['profile']['thumbnail_image_url'],
            ];
        } else {
            return ['status' => 'error'];
        }
    }
}
