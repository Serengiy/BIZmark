<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'preview' => $this->preview,
            'released_at' => $this->released_at->format('Y'),
            'id' => $this->id,
            'rating' => $this->rating(),
            'producer'=>$this->producer,
            'actors' => $this->actors,
            'slug' => $this->slug,
            'reviews' => ReviewResource::collection($this->review)->resolve(),
            'gallery' => GalleryResource::collection($this->gallery)->resolve()
        ];
    }
}
