<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
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
        
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        
        return response()->json(['url' => $url]);
        // return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        // return response(['resp'=>$provider,'message' => 'hi'],200);
        $validated = $this->validateProvider($provider);
        if(!is_null($validated))
        {
            return $validated;
        }
        try {
            $user = Socialite::driver($provider)->stateless()->user();
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
        $token = $userCreated->createToken(env('APP_KEY'))->plainTextToken;

        // $userCreated,200,['Access-Token'=>$token]

        // return redirect('http://127.0.0.1:8080/')->withJson([
        //     'message' => 'Success',
        //     'data' => $userCreated,
        //     'token' => $token
        // ])->withStatus(200);

        Auth::login($userCreated);


        return redirect()->away('http://localhost:8080')->with([
            'message' => 'successs',
            'data' => $userCreated,
            'access_token' => $token
        ]);


        // return response()->json([
        //     'message' => 'successs',
        //     'data' => $userCreated,
        //     'access_token' => $token
        // ]);

    }
    protected function validateProvider($provider)
    {
        if(!in_array($provider,['google','kakao','naver']))
        {
            return response()->json(['error' =>'Please login using Google or Kakao' ],422 );
        }
    }

}
