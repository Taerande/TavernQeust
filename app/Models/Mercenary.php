<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercenary extends Model
{
    use HasFactory;

    
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function characters()
    {
        return $this->belongsTo(Character::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }


}
