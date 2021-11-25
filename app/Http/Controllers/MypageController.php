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
        $partyInfo = Auth::user()->parties()->with(['users','games','schedules'])->get();

        return $partyInfo;

    }
    public function character()
    {
        $CharacterInfo = Auth::user()->characters()->with(['users','games','scans'])->get();

        return $CharacterInfo;

    }
    public function quest()
    {
        $user = Auth::user();

        return $user;

    }
}
