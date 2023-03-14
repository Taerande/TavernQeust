<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Classes\NaverLoginProvider;
use App\Classes\KakaoLoginProvider;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // private $

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Validation
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        // Check User
        $user = User::where('email', '=', $request->email)->first();

        // Check Password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Login data is invalid!'
            ], 401);
        }
        $token = $user->createToken('projecttq')->plainTextToken;

        $response = [
            'autoLogin' => $request->autoLogin,
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }
    public function logout(Request $request)
    {
        // Validation
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'logout Success'], 201);
    }
    public function socialLogin($provider, Request $request)
    {
        $provider = strtoupper($provider);
        $user_data = null;

        switch ($provider) {
            case 'NAVER':
                $loginProvider =  new NaverLoginProvider($request->code, $request->state);
                $user_data = $loginProvider->getUserInfo();
                break;
            case 'KAKAO':
                $loginProvider =  new KakaoLoginProvider($request->code, $request->state);
                $user_data = $loginProvider->getUserInfo();
                break;
            case 'GOOGLE':
                $loginProvider =  new KakaoLoginProvider($request->code, $request->state);
                $user_data = $loginProvider->getUserInfo();
                break;
            default:
                return 'asdf';
        }
        if ($user_data['status'] === 'success') {
            $user =
                User::firstOrCreate(
                    ['email' => $user_data['email']],
                    [
                        'email' => $user_data['email'],
                        'name' => $user_data['name'],
                        'photoUrl' => $user_data['photoUrl'],
                        'provider' => $provider
                    ]
                );
            $token = $user->createToken('projecttq')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
            ];
            return response(['response' => $response], 200);
        }
    }
}
