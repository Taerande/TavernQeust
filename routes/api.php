<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('user',[UserController::class,'indexAuth'])->middleware('auth:sanctum');



Route::prefix('party')->group(function () {
    Route::get('list', [PartyController::class,'index'])->name('party.list');
    Route::get('{id}', [PartyController::class,'show'])->name('party.show');

});


// Route::prefix('user')->group(function () {
//     Route::get('list', [UserController::class,'index'])->name('user.list');
//     Route::get('{id}', [UserController::class,'show'])->name('user.show');

// });
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('mypage', [MypageController::class,'index'])->name('mypage.index');
    
// });

Route::get('login/{provider}',[LoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback',[LoginController::class, 'handleProviderCallback']);


// Route::prefix('auth')->group(function () {
//     Route::middleware('auth:sanctum')->get('/partylist',[PartyController::class, 'index'])->name('party.index');
// });

