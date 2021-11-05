<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToProvider ($provider)
    {
        $validated = $this->validateProvider($provider);
        if(!is_null($validated))
        {
            return $validated;
        }

        return Socialite::driver($provider)->stateless(false)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $validated = $this->validateProvider($provider);
        if(!is_null($validated))
        {
            return $validated;
        }
        try {
            $user = Socialite::driver($provider)->stateless(false)->user();
        }
        catch (ClientException $exception)
        {
            return response()->json(['error'=>'Invalid credentails provided'], 422);
        }

        $userCreated = User::firstOrCreate(
            [
            'email' => $user->getEmail()
            ],
            [
            'email_verified_at' => now(),
            'name' => $user->getName(),
            'status' => true,
            ]
        );
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),

            ],
            [
            'avatar' => $user->getAvatar()
            ]
        );
        $token = $userCreated->createToken('token-name')->plainTextToken;

        return response()->json($userCreated,200,['Access-Token'=>$token]);

    }
    
    protected function validateProvider($provider)
    {
        if(!in_array($provider,['google','kakao','naver']))
        {
            return response()->json(['error' =>'Please login using Google, Kakao or Naver' ],422 );
        }
    }

}
