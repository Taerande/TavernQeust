<?php

use App\Http\Controllers\CharacterController;
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
// Myapge
Route::group(['prefix' => 'mypage', 'middleware' => 'auth:sanctum'], function(){
    Route::get('dashbaord',[MypageController::class,'dashbaord'] )
    ->name('mypage.dashboard');
    Route::get('party',[MypageController::class,'party'])
    ->name('mypage.party');
    Route::get('character',[MypageController::class,'character'])
    ->name('mypage.character');
    Route::get('quest',[MypageController::class,'quest'])
    ->name('mypage.quest');
});

// My Character
Route::group(['prefix' => 'character', 'middleware' => 'auth:sanctum'], function(){
    Route::post('store',[CharacterController::class,'store'] )
    ->name('char.store');
    Route::patch('status',[CharacterController::class,'status'] )
    ->name('char.status');
});

// User정보 가져오기
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/mypage/character', function (Request $request) {
//     return $request->user();
// });



// PartyInfo
Route::prefix('party')->group(function () {
    Route::get('list', [PartyController::class,'index'])->name('party.list');
    Route::get('{id}', [PartyController::class,'show'])->name('party.show');

});

// UserInfo
Route::prefix('user')->group(function () {
    Route::get('list', [UserController::class,'index'])->name('user.list');
    Route::get('{id}', [UserController::class,'show'])->name('user.show');

});
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('mypage', [MypageController::class,'index'])->name('mypage.index');
    
// });


// Socail Login callback
Route::get('login/{provider}',[LoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback',[LoginController::class, 'handleProviderCallback']);

