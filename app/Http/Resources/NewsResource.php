<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RelatedNewsResource;

class NewsResource extends JsonResource
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
            'description' => $this->description,
            'reading_time' => $this->reading_time,
            'created_at' => $this->created_at,
            'path' => $this->getPreviewImagePath(),
            'category' => new NewsCategoryResource($this->category),
            'related' => RelatedNewsResource::collection($this->relatedNews),
        ];
    }
}
