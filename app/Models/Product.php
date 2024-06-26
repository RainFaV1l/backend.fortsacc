<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'stock',
        'delivery',
        'game',
        'mail',
        'price',
        'product_categories_id',
        'preview',
        'currency',
        'popular',
    ];

    public function category() {

        return $this->belongsTo(ProductCategory::class, 'product_categories_id');

    }

    public function populars() {

        return $this->hasMany(PopularProduct::class, 'product_id');

    }

    public function getPreviewImagePath(): string
    {

        return asset(Storage::url($this->preview));

    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array = $this->transform($array);

        $array['product_category_name'] = $this->category->name;

        return $array;
    }
}
