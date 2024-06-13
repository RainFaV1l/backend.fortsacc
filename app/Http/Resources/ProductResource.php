<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'stock' => $this->stock,
            'delivery' => $this->delivery,
            'game' => $this->game,
            'mail' => $this->mail,
            'price' => $this->price,
            'currency' => $this->currency,
            'preview_image' => $this->getPreviewImagePath(),
            'category' => new CategoryResource($this->category),
            'popular' => $this->popular,
            'populars' => PopularResource::collection($this->populars),
        ];
    }
}
