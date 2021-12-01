<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Party;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashbaord()
    {
        $user = Auth::user();

        return $user;

    }
    public function party()
    {
        $user = Auth::user();
        $partyInfo = $user->parties()->with(['users','games','schedules'])->get();
        $partParty = $user->characters()->with(['parties','games'])->get();

        return response([
            'owendParty' => $partyInfo,
            'partParty' => $partParty,

    ],200);

    }
    public function character()
    {
        $user = Auth::user();
        $CharacterInfo =  $user->characters()->with(['users','games','scans'])->get();

        return $CharacterInfo;

    }
    public function quest()
    {
        $user = Auth::user();

        return $user;

    }
}
