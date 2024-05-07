<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MysteryBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'winner_id',
        'expired_at',
    ];

    public function winner() {

        return $this->belongsTo(User::class, 'winner_id');

    }
}
