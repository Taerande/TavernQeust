<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/sanctum/token', function (Request $request) {

    Auth::attempt(['email' => $request->email, 'password' => $request->password]);

    $user = User::where('email', $request->email)->first();

    $token = $user->createToken(env('APP_KEY'))->plainTextToken;

    return response()->json(['user' => $user , 'token' => $token]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
