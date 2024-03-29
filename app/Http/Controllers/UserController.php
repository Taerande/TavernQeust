<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userInfo = auth()->user();

        $charSet = $userInfo->characters()->get(['id', 'name']);

        return response(['userData' => $userInfo, 'charData' => $charSet]);
    }
    public function indexAuth(Request $request)
    {
        dd($request);
        // $userInfo = User::find($id);

        return $request;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {

        $userInfo = User::find($id)->only(['id', 'email', 'name']);

        $charInfo = User::find($id)->characters()->get(['game_id', 'name', 'spec']);

        $partyInfo = Party::where('user_id', $id)->where('status', 1)->get();

        $partyInfo->map(function ($party) {
            $party['spec'] = $party['recruit'];
            unset($party['recruit']);
        });

        return response()->json([$userInfo, $charInfo, $partyInfo], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
