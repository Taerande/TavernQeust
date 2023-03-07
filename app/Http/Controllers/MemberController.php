<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Party;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function show($id)
    {
        //member 와 applicant 보구분하여 보여줄것.
        // 1. leader check
        $schedule_character = Schedule::find($id)->characters()->get();
        $user_character = Auth::user()->characters()->get('id')->toArray();

        $id_array = array_column($user_character, 'id');

        $im_leader = false;
        $applicants = [];
        foreach ($schedule_character as $character) {
            $is_leader = $character->pivot->grade === 'leader';
            if ($is_leader) {
                if (in_array($character->id, $id_array)) {
                    $im_leader = true;
                }
            }
        };


        if ($im_leader) {
            foreach ($schedule_character as $character) {
                if ($character->pivot->grade === 'applicant') {
                    $applicants[] = $character;
                }
            }
        }
        return response(['applicants' => $applicants], 200);


        // $partyDetail = Party::where('id',$id)->with('games','users')->first();

        // $mebers = $partyDetail->characters()->wherePivot('status','!=','-2')->orderBy('grade','asc')->get();


    }
    public function status(Request $request)
    {
        $req_data = json_decode($request->getContent(), true);

        $user = auth()->user();
        $user_char_set = $user->characters()->get(['id']);

        // 요청한 캐릭터와 스케쥴의 상관관계
        $target_schedule = Character::find($req_data['character_id'])->schedules()->where('schedule_id', $req_data['schedule_id'])->get()[0];

        // Leader 의 Character_id 찾기
        $leader_char = $target_schedule->characters()->where('grade', 'leader')->get(['character_id'])[0];

        $is_leader = false;
        $is_myChar = false;
        $is_applicants = false;
        // Leader character가 내 보유 Character 인지 확인
        foreach ($user_char_set as $id) {
            if ($id->id == $leader_char->character_id) {
                $is_leader = true;
            }
            if ($id->id == $req_data['character_id']) {
                $is_myChar = true;
            }
        };
        // 해당 인원이 지원자인이 check
        if ($target_schedule->pivot->grade == 'applicant') {
            $is_applicants = true;
        }

        // 리더인 경우
        if ($is_leader) {
            // can update status & grade
            $target_schedule->characters()->syncWithoutDetaching([
                $req_data['character_id'] => [
                    'status' => $req_data['status'] * 1,
                    'grade' => isset($req_data['grade']) ? $req_data['grade'] : $target_schedule->pivot->grade,
                ]
            ]);
            return response(['success' => 'im leader'], 200);
        }

        // 내 캐릭이면서 지원자가 아닌 상태
        if ($is_myChar && !$is_applicants) {
            // can update status
            $target_schedule->characters()->syncWithoutDetaching([
                $req_data['character_id'] => [
                    'status' => $req_data['status'] * 1,
                ]
            ]);
            return response(['success' => 'it is my char'], 200);
        }

        //
        return response(['message' => "You can't update."], 404);
    }

    public function apply(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        $has_apllied = $schedule->characters()->wherePivot('character_id', $request->char['id'])->get();

        if ($has_apllied->count()) {
            return response(['message' => 'already applied for party'], 403);
        } else {
            $schedule->characters()->syncWithoutDetaching([
                $request->char['id'] => [
                    'grade' => 'applicant',
                    'spec' => $request->char['position'],
                    'apply' => $request->comment
                ]
            ]);
            return response(['message' => 'success'], 200);
        }
    }
    public function update(Request $request, $id)
    {
        // member table 을 속에 grade로 구분하는게 맞다.
        // $id로 들어오는 파티의 member table 구성,
        // api_token을 통해 들어오는 유저의 char_id set 만들기
        // 해당 char_id set과 member table의 char_id 비교

        // 1. 파티장인 경우
        // 2. 오피서인 경우
        // 3. 멤버인 경우 statuts, memo 변경
        // 4. 게스트인 경우

        request()->validate([
            'char_id' => 'nullable',
            'grade' => 'nullable',
            'status' => 'nullable',
            'apply' => 'nullable',
            'reject' => 'nullable',
            'memo' => 'nullable',
        ]);

        $partyTarget = Party::find($id);
        $charTarget = Character::find($request->char_id);


        //파티와 요청하는 캐릭터가 연관되어 있는지 판단
        $partyCorrect = $partyTarget->characters()->where('character_id', $request->char_id)->get();
        $is_involved = $partyCorrect->count() > 0;


        if ($is_involved) {
            // auth()->user()와 해당 파티의 상관관계 확인
            // party->character->user_id = auth()->id

            $authChar = $partyTarget->characters()->where('user_id', auth()->user()->id)->get();

            $newCharSet = [];
            foreach ($authChar as $charId) {
                $newCharSet[] = $charId->pivot->grade;
                $newCharSet[] = $charId->id;
            };



            $is_manager = !empty(array_intersect(['leader', 'officer'], $newCharSet));
            $is_reqAuthCorrect = in_array($request->char_id, $newCharSet);


            if ($is_manager) {
                $partyTarget->characters()->syncWithoutDetaching([
                    $request->char_id => [
                        'status' => $request->status,
                        'grade' => $request->grade,
                        // 'reject' => $request->reject,
                    ]
                ]);
                // $charTarget->parties()->syncWithoutDetaching([
                //     $id =>[
                //         'status' => $request->status,
                //         'grade' => $request->grade,
                //         // 'reject' => $request->reject,
                //     ]
                //     ]);
                return response()->json(['message' => 'success']);
            } elseif ($is_reqAuthCorrect) {

                $charTarget->parties()->syncWithoutDetaching([
                    $id => [
                        'status' => $request->status,
                        'grade' => $request->grade,
                    ]
                ]);
            }
        }
        return response()->json(['message' => 'success']);
    }
    public function detach(Request $request, $id)
    {

        $request->validate([
            'char_id' => 'required',
        ]);

        $partyTarget = Party::find($id);
        $charTarget = Character::find($request->char_id);

        //파티와 요청하는 캐릭터가 연관되어 있는지 판단
        $partyCorrect = $partyTarget->characters()->where('character_id', $request->char_id)->get();
        $is_involved = $partyCorrect->count() > 0;

        if ($is_involved) {
            // auth()->user()와 해당 파티의 상관관계 확인
            // party->character->user_id = auth()->id

            $authChar = $partyTarget->characters()->where('user_id', auth()->user()->id)->get();

            $newCharSet = [];
            foreach ($authChar as $charId) {
                $newCharSet[] = $charId->pivot->grade;
                $newCharSet[] = $charId->id;
            };

            //권한 확인, is_manager, is_req, auth
            $is_manager = !empty(array_intersect(['leader', 'officer'], $newCharSet));

            if ($is_manager) {
                $charTarget->parties()->detach($id);
            }
        }
    }
}
