<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'end',
        'start',
        'description',
        'title',
        'recruit',
        'goal',
        'dungeon',
        'status',
        'difficulty',
        'reward'
    ];

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot(['grade', 'status', 'apply', 'reject', 'memo', 'spec'])->withTimestamps();
    }

    public function offers()
    {
        return $this->characters()->with('games')->wherePivot('grade', 'applicant');
    }
}
