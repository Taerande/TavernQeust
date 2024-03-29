<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'provider',
        'password',
        'photoUrl',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function providers()
    {
        return $this->hasMany(Provider::class, 'user_id', 'id');
    }

    public function parties()
    {
        return $this->hasMany(Party::class, 'user_id', 'id');
    }
    // public function schedules()
    // {
    //     return $this->hasMany(Schedule::class, 'user_id', 'id');
    // }

    public function characters()
    {
        return $this->hasMany(Character::class, 'user_id', 'id');
    }

    public function mercenaries()
    {
        return $this->hasMany(Mercenary::class, 'user_id', 'id');
    }
}
