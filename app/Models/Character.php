<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function mercernaries()
    {
        return $this->hasOne(Mercenary::class);
    }
    public function parties()
    {
        return $this->belongsToMany(Party::class)->withPivot(['grade', 'status', 'memo'])->with(['schedules'])->withTimestamps();
    }
    public function games()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class)->withPivot(['character_id', 'schedule_id', 'grade', 'status', 'apply', 'reject', 'memo', 'spec'])->withTimestamps();
    }
    public function scans()
    {
        return $this->hasMany(Scan::class);
    }
}
