<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlizzardApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $clientId;
    protected $clientSecret;
    protected $redirectUrl;

    public function __construct()
    {
        $this->clientId = $_ENV['BLIZZARD_CLIENT_ID'];
        $this->clientSecret = $_ENV['BLIZZARD_CLIENT_SECRET'];
        $this->redirectUrl = $_ENV['BLIZZARD_REDIRECT_URL'];
    }

    public function index(Request $request)
    {
        return response(['message' => 'hi', 'request' => $request], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function oauth_token(Request $request)
    {
        $code = $request->query('code');

        // return  response(['message' => 'hi', 'request' => $request], 200);

        $promise = Http::post("https://oauth.battle.net/token?client_id={$this->clientId}&client_secret={$this->clientSecret}&grant_type=authorization_code&redirect_uri={$this->redirectUrl}&code= {$request}&scope=wow.profile");

        $resp = $promise->wait();
        echo $resp;
        echo 'hi';
        return  response(['message' => 'hi', 'request' => $resp], 200);
    }
    public function access_token(Request $request)
    {
        // return  response(['message' => 'hi', 'request' => $request], 200);


        $resp = Http::post("https://oauth.battle.net/token?client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret . "&grant_type=client_credentials&scope=wow.profile");

        if ($resp->successful()) {
            // Request was successful
            // Do something with the response data
            return response(['message' => 'success', 'data' => $resp->json()]);
        } else {
            // Request failed
            return response(['message' => 'error']);
            // Handle the error
        }

        // return  response(['message' => 'hi', 'result' => $resp->body()], $resp->status());
        // if ($resp->successful()) {
        // } else {
        //     return response(['message' => 'Error Occured', 'Error' => $resp->body()], 400);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
