<?php

use App\Http\Controllers\CharacterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ScheduleController;
use App\Models\Character;
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
// Myapge & My Informations
Route::group(['prefix' => 'mypage', 'middleware' => 'auth:sanctum'], function(){
    Route::get('dashbaord',[MypageController::class,'dashbaord'] )
    ->name('mypage.dashboard');
    Route::get('party',[MypageController::class,'party'])
    ->name('mypage.party');
    Route::get('character',[MypageController::class,'character'])
    ->name('mypage.character');
    Route::get('quest',[MypageController::class,'quest'])
    ->name('mypage.quest');
    Route::get('schedule/index',[ScheduleController::class,'index'])
    ->name('schedule.index');
});

Route::group(['prefix' => 'member', 'middleware' => 'auth:sanctum'], function(){
    Route::post('apply',[MemberController::class,'apply'] )->name('member.apply');
    Route::post('reject',[MemberController::class,'apply'] )->name('member.reject');
    Route::patch('status',[MemberController::class,'status'] )->name('member.status');
    Route::patch('grade',[MemberController::class,'grade'] )->name('member.grade');
});


// My Character
Route::group(['prefix' => 'character', 'middleware' => 'auth:sanctum'], function(){
    Route::patch('status',[CharacterController::class,'status'])
    ->name('char.status');
    Route::post('store',[CharacterController::class,'store'])
    ->name('char.store');
});

//My Party

Route::group(['prefix' => 'party', 'middleware' => 'auth:sanctum'], function(){
    Route::patch('status',[PartyController::class,'status'])
    ->name('party.status');
    Route::post('store',[PartyController::class,'store'])
    ->name('party.store');
});

// User정보 가져오기
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/mypage/character', function (Request $request) {
//     return $request->user();
// });

// Member Controller


// PartyInfo
Route::prefix('party')->group(function () {
    Route::get('list', [PartyController::class,'index'])->name('party.list');
    Route::get('{id}', [PartyController::class,'show'])->name('party.show');
    Route::group(['prefix' => '{id}/member', 'middleware' => 'auth:sanctum'],function(){
        Route::get('',[MemberController::class,'show']);
        Route::post('',[MemberController::class,'apply']);
        Route::patch('',[MemberController::class,'update']);
        Route::delete('',[MemberController::class,'destory']);
    });
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

