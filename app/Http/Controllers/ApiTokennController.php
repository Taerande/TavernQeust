<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiTokennController extends Controller
{
    public function createApiToken(Request $request){

    Auth::attempt(['email' => $request->email, 'password' => $request->password]);
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken(env('APP_KEY'))->plainTextToken;

    return response(['user' => $user , 'token' => $token],200)->withCookie('api_token', $token, 45000);
    }
}
