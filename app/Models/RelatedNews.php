<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class RelatedNews extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'related_news_id',
    ];

    public function news() {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function relatedNews() {
        return $this->belongsTo(News::class, 'related_news_id');
    }
}
