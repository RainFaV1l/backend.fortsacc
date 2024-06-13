<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelatedNewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->news->id,
            'name' => $this->news->name,
            'description' => $this->news->description,
            'reading_time' => $this->news->reading_time,
            'created_at' => $this->news->created_at,
            'path' => $this->news->getPreviewImagePath(),
            'category' => new NewsCategoryResource($this->news->category),
        ];
    }
}
