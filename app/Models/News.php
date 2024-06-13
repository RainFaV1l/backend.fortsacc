<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class News extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'isPublished',
        'news_category_id',
        'path',
        'reading_time',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function getPreviewImagePath(): string
    {
//        return asset(Storage::url($this->path));
        return $this->path;
    }

    public function relatedNews()
    {
        return $this->hasMany(RelatedNews::class, 'related_news_id');
    }

    public function news()
    {
        return $this->hasMany(RelatedNews::class, 'news_id');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array = $this->transform($array);

        $array['news_category_name'] = $this->category->name;

        return $array;
    }
}
