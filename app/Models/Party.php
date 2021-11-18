<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;
    
    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function games()
    {
        return $this->belongsTo(Game::class,'game_id');
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot(['grade','status','apply'])->withTimestamps();
    }
    
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
