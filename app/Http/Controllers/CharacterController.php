<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $partylist = Character::where('status',1)->paginate(4);

        return response($partylist);
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


        $newSpec = implode("",$request['spec']);

        $request['spec'] = $newSpec;

        $data = request()->validate([
            'game_id' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'spec' => 'required',
        ]);

        auth()->user()->characters()->create($data);
        
        $ownCharacter = auth()->user()->characters()->orderByDesc('created_at')->first();
        

        return response($ownCharacter);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character, $id)
    {
        
        $characterDetail = Character::where('id',$id)->first();
        return $characterDetail;
    }

    public function status(Request $request)
    {

        $data = request()->validate([
            'id' => '',
            'status' => ''
        ]);

        auth()->user()->characters()->where('id',$request->id)->update($data);


        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Character $character)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character)
    {
        //
    }
}
