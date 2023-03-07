<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Party;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MypageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = Auth::user();

        $characters = $user->characters()->with(['parties', 'schedules', 'games'])->get();

        return response([
            'characters' => $characters,
            'user' => $user,
        ], 201);
    }
    public function schedule()
    {
        $user = Auth::user();
        $characters = $user->characters()->with(['parties', 'schedules', 'games'])->get();

        $partScheduleSet = [];
        $appliedScheduleSet = [];
        $ownedScheduleSet = [];



        foreach ($characters as $char) {
            $scheduleAll = $char->schedules()->with(['characters'])->orderBy('start')->get();
            foreach ($scheduleAll as $schedule) {
                $is_manager = in_array($schedule->pivot->grade, ['leader', 'officer']);
                $is_applicant = in_array($schedule->pivot->grade, ['applicant']);
                if ($is_manager) {
                    $ownedScheduleSet[] = $schedule;
                } elseif ($is_applicant) {
                    $appliedScheduleSet[] = $schedule;
                } else {
                    $partScheduleSet[] = $schedule;
                }
            }
        }

        // $partyInfo->map(function ($item, $key) {
        //     return $item['offers'] = $item->offers()->get();
        // });
        return response([
            'ownedSchedules' => $ownedScheduleSet,
            'partSchedules' => $partScheduleSet,
            'appliedSchedules' => $appliedScheduleSet,

        ], 200);
    }
    public function checkSchedule(Request $request)
    {
        $user = Auth::user();
        $schedule_id = $request->schedule_id * 1;
        $character_id_set = $user->characters()->get(['id'])->toArray();

        $schedule_member_set = DB::table('character_schedule')->whereRaw("schedule_id = $schedule_id")->get()->toArray();

        $result = [];
        foreach ($schedule_member_set as $member) {
            if (in_array($member->character_id, array_column($character_id_set, 'id'))) {
                $result[] = $member;
            }
        }
        return response(['involved_character' => $result], 200);
    }
    public function character()
    {
        $user = Auth::user();
        $Characters =  $user->characters()->with(['games'])->get();
        $result = [];
        foreach ($Characters as $char) {
            $result[] = $char->schedules()->get(['schedule_id', 'grade', 'status']);
        }

        return response(['result' => $result], 200);
    }
    public function quest()
    {
        $user = Auth::user();

        return $user;
    }
}
