<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function show($id)
    {
        $party = Party::find($id);
        if($party->user_id == Auth::user()->id){

            $applicants = $party->characters()
            ->wherePivot('grade','applicant')
            ->get();


            $res = $applicants->makeHidden(['description', 'server_faction', 'created_at', 'updated_at','game_id','id','status']);

            return response($res,200);

        }else{
            return response(['message'=>'Not Authorized'],200);
        }


        // $partyDetail = Party::where('id',$id)->with('games','users')->first();

        // $mebers = $partyDetail->characters()->wherePivot('status','!=','-2')->orderBy('grade','asc')->get();


    }

    public function apply(Request $request, $id)
    {
        $party = Party::find($id);

        $has_apllied = $party->characters()->wherePivot('character_id',$request->char_id)->get();

        if($has_apllied->count()){
            return response(['message' => 'already applied for party'],200);
        }else{
            $party->characters()->syncWithoutDetaching([
                $request->char_id => [
                    'grade' => 'applicant',
                    'apply' => $request->apply
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

        $request->validate([
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
        $partyCorrect = $partyTarget->characters()->where('character_id',$request->char_id)->get();
        $is_involved = $partyCorrect->count()>0;

        if($is_involved){
            // auth()->user()와 해당 파티의 상관관계 확인
            // party->character->user_id = auth()->id
            
            $authChar = $partyTarget->characters()->where('user_id',auth()->user()->id)->get();

            $newCharSet = [];
            foreach($authChar as $charId){
                $newCharSet[] = $charId->pivot->grade;
                $newCharSet[] = $charId->id;
            };


            $is_manager = !empty(array_intersect(['leader','officer'],$newCharSet));
            $is_reqAuthCorrect = in_array($request->char_id,$newCharSet);

            if($is_manager)
            {
                $charTarget->parties()->syncWithoutDetaching([
                    $id =>[
                        'status' => $request->status,
                        'grade' => $request->grade,
                        'reject' => $request->reject,
                    ]
                    ]);
            }
            elseif($is_reqAuthCorrect)
            {

                $charTarget->parties()->syncWithoutDetaching([
                    $id =>[
                        'status' => $request->status,
                    ]
                    ]);
            }
        }



    }
    public function detach(Request $request, $id)
    {

        $request->validate([
            'char_id' => 'required',
        ]);

        $partyTarget = Party::find($id);
        $charTarget = Character::find($request->char_id);

        //파티와 요청하는 캐릭터가 연관되어 있는지 판단
        $partyCorrect = $partyTarget->characters()->where('character_id',$request->char_id)->get();
        $is_involved = $partyCorrect->count()>0;

        if($is_involved){
            // auth()->user()와 해당 파티의 상관관계 확인
            // party->character->user_id = auth()->id
            
            $authChar = $partyTarget->characters()->where('user_id',auth()->user()->id)->get();

            $newCharSet = [];
            foreach($authChar as $charId){
                $newCharSet[] = $charId->pivot->grade;
                $newCharSet[] = $charId->id;
            };

            //권한 확인, is_manager, is_req, auth
            $is_manager = !empty(array_intersect(['leader','officer'],$newCharSet));

            if($is_manager)
            {
                $charTarget->parties()->detach($id);
            }
        }


    }
}