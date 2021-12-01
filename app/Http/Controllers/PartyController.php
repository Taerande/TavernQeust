<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function test(Request $request)
     {

        function goalOperator( $data ){
            switch($data){
                case 'gt': return '>';
                case 'lt': return '<';
                case 'gte': return '>=';
                case 'lte': return '<=';
                case 'eq': return '=';
                case 'neq': return '!=';
            };
        }

        


        $partyFiltered = Party::where('status',1)
        ->where('recruit','like','%'.request()->spec.'%')
        ->where('difficulty','like','%'.request()->diff.'%')
        ->where(function($query){
            if(!empty(request()->goal)){
                $goalOperator = goalOperator(request()->oper);
                $query->where('goal',$goalOperator,request()->goal);
            }else{
                $query;
            }
        })
        ->with('games','users')->paginate(4);

       
        dd($partyFiltered, goalOperator(request()->oper),request()->goal,!empty(request()->goal));

     }

     public function status(Request $request)
    {

        $data = request()->validate([
            'id' => 'integer',
            'status' => 'integer'
        ]);

        auth()->user()->parties()->where('id',$request->id)->update($data);


        return response($data);
    }



    public function index(Request $request)
    {
        function goalOperator( $data ){
            switch($data){
                case 'gt': return '>';
                case 'lt': return '<';
                case 'gte': return '>=';
                case 'lte': return '<=';
                case 'eq': return '=';
                case 'neq': return '!=';
            };
        }

        


        $partyFiltered = Party::where('status',1)
        ->where('recruit','like','%'.request()->spec.'%')
        ->where('difficulty','like','%'.request()->diff.'%')
        ->where(function($query){
            if(!empty(request()->goal)){
                $goalOperator = goalOperator(request()->oper);
                $query->where('goal',$goalOperator,request()->goal);
            }else{
                $query;
            }
        })
        ->with('games','users')->paginate(4)->appends(request()->query());

        return response($partyFiltered,200);
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

        $user_id = auth()->user()->id;


        $data = request()->validate([
            'user_id' => '',
            'game_id' => '',
            'dungeon' => '',
            'difficulty' => '',
            'goal' => '',
            'title' => '',
            'description' => '',
            'recruit' => '',
            'reward' =>'',
            'status' =>'',
        ]);
        $data['user_id'] = $user_id;

        auth()->user()->parties()->create($data);

        $createdParty = Party::where('user_id',$user_id)->orderByDesc('created_at')->first();

        foreach($request->schedule as $schedule ){
            if($schedule['start'] > $schedule['end']){
                $date = date_create($schedule['date'])->modify('+1 day');
                $dateForamted = date_format($date, "Y-m-d");
            }else{
                $dateForamted = $schedule['date'];
            };

            $createdParty->schedules()->create([
                'party_id' => $createdParty->id,
                'start' => $schedule['date']." ".$schedule['start'],
                'end' => $dateForamted." ".$schedule['end']
            ]);
        };

        $createdParty->characters()->syncWithoutDetaching([
            $request->char_id => [
                'grade' => 'leader'
            ]
            ]);

        
        return response('success',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party, $id)
    {
        $partyDetail = Party::where('id',$id)->with('games','users')->first();

        $mebers = $partyDetail->characters()->wherePivot('status','!=','-2')->orderBy('grade','asc')->get();

        return ['partyInfo' => $partyDetail,
            'memberInfo' => $mebers];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(Party $party)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $party)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $party)
    {
        //
    }
}
