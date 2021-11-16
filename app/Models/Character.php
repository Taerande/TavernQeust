<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'name',
        'dsecription',
        'spec',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function mercernaries()
    {
        return $this->hasOne(Mercenary::class);
    }
}
