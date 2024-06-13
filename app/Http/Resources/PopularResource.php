<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PopularResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->popularProduct->id,
            'name' => $this->popularProduct->name,
            'price' => $this->popularProduct->price,
            'currency' => $this->popularProduct->currency,
            'preview_image' => $this->popularProduct->getPreviewImagePath(),
        ];
    }
}
