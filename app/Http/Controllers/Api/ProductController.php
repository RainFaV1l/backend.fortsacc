<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PopularResource;
use App\Http\Resources\ProductResource;
use App\Models\PopularProduct;
use App\Models\Product;
use App\Models\SliderProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return ProductResource::collection($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::query()->findOrFail($id);

        return new ProductResource($product);
    }

    public function slider()
    {
        $products = SliderProduct::all();

        return PopularResource::collection($products);
    }
}
