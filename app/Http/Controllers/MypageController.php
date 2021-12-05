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
        $characters = $user->characters()->with(['parties','games'])->get();

        $partPartySet = [];
        $appliedPartySet = [];

        
        foreach($characters as $char)
        {
            $partyAll = $char->parties()->with(['users','games','schedules'])->get();
            foreach($partyAll as $partParty)
            {
                $is_manager = in_array($partParty->pivot->grade,['leader','officer']);
                $is_applicant = in_array($partParty->pivot->grade,['applicant']);
                if(!$is_manager)
                {
                    $partPartySet[] = $partParty;
                }elseif($is_applicant)
                {
                    $appliedPartySet[] = $partParty;
                }
            }
        }

        return response([
            'owendParty' => $partyInfo,
            'partParty' => $partPartySet,
            'appliedParty' => $appliedPartySet,

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
