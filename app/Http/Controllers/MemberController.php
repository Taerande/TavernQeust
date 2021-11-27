<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function apply(Request $request)
    {
        $party = Party::find($request->party_id);

        $party->characters()->syncWithoutDetaching([
            $request->char_id => [
                'status' => "-2",
                'apply' => $request->apply
            ]
            ]);

        return response(['message' => 'success'], 200);

    }
    public function reject(Request $request)
    {
        dd($request);
    }
    public function status(Request $request)
    {
        dd($request);
    }
    public function grade(Request $request)
    {
        dd($request);
    }
}