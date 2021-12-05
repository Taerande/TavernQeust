<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Routing\Route;

class MemberPolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function involved()
    {
    }

    public function leader()
    {

    }

    public function officer()
    {

    }

    public function member()
    {

    }
    
    public function guest()
    {

    }

}
