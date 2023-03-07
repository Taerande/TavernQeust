<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Character;
use App\Models\Party;
use App\Models\Schedule;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schedules = Schedule::where('start', '>=', date('Y-m-d H:i:s'))->where('status', '=', 1)->with('party')->paginate(12);

        $beforeData = $schedules->getCollection();
        foreach ($beforeData as $index => $value) {
            $beforeData[$index]->recruit = explode(",", $value->recruit);
        };

        $schedules->setCollection($beforeData);

        return response($schedules, 200);
        // my Schedule
        // $parties = Auth::user()->parties()->get(['id']);

        // $data = [];

        // foreach ($parties as $party) {
        //     $schedule = Schedule::where('party_id', $party['id'])->get(['party_id', 'start', 'end']);
        //     $data[] = $schedule;
        // };


        // dd($user);

        // dd($user->partySchedules()->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $result = $request->all();
        $schedule = Schedule::create([
            'title' => $request->title,
            'description' => $request->description,
            'dungeon' => $request->dungeon,
            'difficulty' => $request->difficulty,
            'goal' => $request->goal,
            'recruit' => $request->recruit,
            'start' => new DateTime($request->start),
            'end' => new DateTime($request->end),
            'reward' => $request->reward,
        ]);

        $schedule->characters()->attach([
            $request->character_id => [
                'schedule_id' => $schedule->id,
                'grade' => 'leader',
                'status' => 1,
            ]
        ]);
        // return response(['id' => $result], 201);

        return response(['schedule_id' => $schedule->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request)
    {
        $limit = 12;
        $queries = $request->all();
        $scheduleInfo = Schedule::where('status', '=', 1)->whereNotNull('party_id',);
        $start = null;
        $end = null;
        $minReward = null;
        $maxReward = null;
        foreach ($queries as $key => $value) {
            // recruit 밸류 검사
            if ($key == 'recruit') {
                // where group화
                // 사실 제2 정규화 하는게 좋을듯 like 안쓰는게 best
                $scheduleInfo->where(function ($query) use ($value) {
                    foreach ($value as $recruitItem) {
                        if (str_contains($recruitItem, 'all')) {
                            // all Keyword 있으면 앞에꺼만 포함해도 찾기
                            $explodedStr = explode("-", $recruitItem)[0];
                            $query->orWhere('recruit', 'like', '%' . $explodedStr . '%');
                        } else {
                            // all Keywrod 없으면 정확히 맞는거만 찾기
                            $query->orWhere('recruit', 'like', '%' . $recruitItem . '%');
                        }
                    }
                });
                // Date Time 검사
            } elseif ($key == 'start') {
                $start = $value;
            } elseif ($key == 'end') {
                $end = $value;
            } elseif ($key == 'reward_min') {
                $minReward = $value * 1;
            } elseif ($key == 'reward_max') {
                $maxReward = $value * 1;
            } elseif ($key == 'page') {
                // Pagination Offset
                $scheduleInfo->offset(($value - 1) * $limit);
            } else {
                // 나머지 검사
                $scheduleInfo->where($key, $value);
            }
        }
        if ($start || $end) {
            $startRange = $start ? $start : date('Y-m-d H:i:s');
            if ($end) {
                $endRange = DateTime::createFromFormat('Y-m-d H:i:s', $end);
            } else {
                $tempEndDateTime = new DateTime($start);
                $tempEndDateTime->add(new DateInterval('P1M'));
                $endRange = $tempEndDateTime->format('Y-m-d H:i:s');
            }
            $scheduleInfo->where(function ($query) use ($startRange, $endRange) {
                $query->whereBetween('start', [$startRange, $endRange])->whereBetween('end', [$startRange, $endRange]);
            });
        }
        if ($minReward || $maxReward) {
            $startRange = $minReward ? $minReward : 0;
            if ($maxReward) {
                $endRange = $maxReward;
            } else {
                $endRange = 999999999999;
            }
            $scheduleInfo->whereBetween('reward', [$startRange, $endRange]);
        }
        $scheduleInfo = $scheduleInfo->orderBy('start', 'ASC')->with('party')->paginate($limit)->withQueryString();
        $beforeData = $scheduleInfo->getCollection();
        foreach ($beforeData as $index => $value) {
            $beforeData[$index]->recruit = explode(",", $value->recruit);
        };

        return response($scheduleInfo, 200);
    }
    public function show(Schedule $schedule, $id)
    {
        $scheduleInfo = Schedule::find($id * 1);
        $partyId = $scheduleInfo['party_id'];
        $party = Party::where('id', $partyId)->with('games', 'users')->first();
        $members = $scheduleInfo->characters()->wherePivot('grade', '!=', 'applicant')->orderBy('grade', 'asc')->get();
        $scheduleInfo->recruit = explode(",", $scheduleInfo->recruit);

        return [
            'scheduleInfo' => $scheduleInfo,
            'partyInfo' => $party,
            'members' => $members
        ];
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule, $id)
    {
        $schedule = Schedule::find($id);
        $leader_char = $schedule->characters()->wherePivot('grade', 'leader')->first();

        $user = auth()->user();

        if ($leader_char->user_id === $user->id) {
            $result = [];
            $taget_character_collection = $schedule->characters()->get();
            foreach ($taget_character_collection as $char) {
                $char->schedules()->wherePivot('schedule_id', $id)->detach();
            }
            $schedule->delete();
            return response(['2' => 'deleted'], 200);
        } else {
            return response(['message' => 'not authorized'], 401);
        }
    }
}
