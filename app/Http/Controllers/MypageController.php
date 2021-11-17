<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Party;
use App\Models\User;
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
        $partyInfo = Auth::user()->parties()->with(['users','games'])->get();

        return $partyInfo;

    }
    public function character()
    {
        $CharacterInfo = Auth::user()->characters()->with(['users','games'])->get();

        return $CharacterInfo;

    }
    public function quest()
    {
        $user = Auth::user();

        return $user;

    }
}
