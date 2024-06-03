<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'referral_link',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function winners() {
        return $this->hasMany(MysteryBox::class, 'winner_id');
    }

    public function carts() {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function participants() {
        return $this->hasMany(MysteryBoxParticipant::class, 'participant_id');
    }

    public function referrals()
    {
        return $this->hasMany(UserReferral::class, 'user_id');
    }

    public function providers()
    {
        return $this->hasMany(Provider::class,'user_id','id');
    }
}
