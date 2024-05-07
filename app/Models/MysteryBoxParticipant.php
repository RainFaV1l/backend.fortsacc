<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MysteryBoxParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'mystery_boxes_id',
    ];

    public function participant() {

        return $this->belongsTo(User::class, 'participant_id');

    }

    public function mysteryBox() {

        return $this->belongsTo(User::class, 'mystery_boxes_id');

    }
}
