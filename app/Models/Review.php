<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Review extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'full_name',
        'message',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array = $this->transform($array);

        $array['user_name'] = $this->user->name;
        $array['user_surname'] = $this->user->surname;

        return $array;
    }
}
