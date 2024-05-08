<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_id',
        'user_id',
        'referral_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referral()
    {
        return $this->belongsTo(User::class, 'referral_id');
    }
}
