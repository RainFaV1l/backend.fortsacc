<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ProductCategory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name'
    ];

    public function product() {

        return $this->belongsTo(Product::class, 'product_id', 'id');

    }

    public function popularProduct() {

        return $this->belongsTo(Product::class, 'popular_product_id', 'id');

    }
}
