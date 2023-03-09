<?php

use App\Http\Controllers\BlizzardApiController;
use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ScheduleController;
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
Route::group(['prefix' => 'mypage', 'middleware' => 'auth:sanctum'], function () {
    Route::get('dashboard', [MypageController::class, 'dashboard'])
        ->name('mypage.dashboard');
    Route::get('schedule', [MypageController::class, 'schedule'])
        ->name('mypage.schedule');
    Route::get('character', [MypageController::class, 'character'])
        ->name('mypage.character');
    Route::get('schedule/check', [MypageController::class, 'checkSchedule'])
        ->name('mypage.schedule.check');
    // Route::get('quest', [MypageController::class, 'quest'])
    //     ->name('mypage.quest');
});


// My Character
Route::group(['prefix' => 'character', 'middleware' => 'auth:sanctum'], function () {
    Route::patch('status', [CharacterController::class, 'status'])
        ->name('char.status');
    Route::post('', [CharacterController::class, 'store'])
        ->name('char.store');
    Route::delete('', [CharacterController::class, 'destroy'])
        ->name('char.destroy');
});

// Character_Schedule Controller for Leader
Route::group(['prefix' => 'member', 'middleware' => 'auth:sanctum'], function () {
    Route::post('apply', [MemberController::class, 'apply'])->name('member.apply');
    Route::post('reject', [MemberController::class, 'apply'])->name('member.reject');
    Route::patch('status', [MemberController::class, 'status'])->name('member.status');
    Route::patch('grade', [MemberController::class, 'grade'])->name('member.grade');
});

//My Party
Route::group(['prefix' => 'party', 'middleware' => 'auth:sanctum'], function () {
    Route::patch('status', [PartyController::class, 'status'])
        ->name('party.status');
    Route::post('store', [PartyController::class, 'store'])
        ->name('party.store');
});


// Party
Route::prefix('party')->group(function () {
    Route::get('list', [PartyController::class, 'index'])->name('party.list');
    Route::get('{id}', [PartyController::class, 'show'])->name('party.show');

    // Member Controller
    Route::group(['prefix' => '{id}/member', 'middleware' => 'auth:sanctum'], function () {
        Route::get('', [MemberController::class, 'show']);
        Route::post('', [MemberController::class, 'apply']);
        Route::patch('', [MemberController::class, 'update']);
        Route::post('/detach', [MemberController::class, 'detach']);
    });
});


// Schedule
Route::prefix('schedule')->group(function () {
    Route::get('list', [ScheduleController::class, 'index'])->name('schedule.list');
    Route::get('{id}', [ScheduleController::class, 'show'])->name('schedule.show');
    Route::get('', [ScheduleController::class, 'query'])->name('schedule.query');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::delete('{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
        Route::post('', [ScheduleController::class, 'store'])->name('schedule.store');
    });

    Route::group(['prefix' => '{id}/member', 'middleware' => 'auth:sanctum'], function () {
        Route::get('', [MemberController::class, 'show']);
        Route::post('', [MemberController::class, 'apply']);
        Route::patch('', [MemberController::class, 'update']);
        Route::post('/detach', [MemberController::class, 'detach']);
    });
});

// User
Route::prefix('user')->group(function () {
    Route::post('', [UserController::class, 'index'])->middleware('auth:sanctum')->name('user.index');
    Route::post('list', [UserController::class, 'list'])->name('user.list');
    Route::post('{id}', [UserController::class, 'show'])->name('user.show');
});


// Auth, Login & logout
Route::post('login', [UserLoginController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('logout', [UserLoginController::class, 'logout'])->name('logout');
// Sociallite with kakao naver
// Route::get('login/{provider}', [LoginController::class, 'redirectToProvider']);
// Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback']);


// Blizzard Apis
Route::prefix('blizzard')->group(function () {
    Route::post('oauth_token', [BlizzardApiController::class, 'oauth_token'])->name('blizzard.oauth');
    Route::post('access_token', [BlizzardApiController::class, 'access_token'])->name('blizzard.access');
});
