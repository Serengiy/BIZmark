<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieMinifiedResource extends JsonResource
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
            'preview' => $this->preview,
            'released_at' => $this->released_at->format('Y'),
            'id' => $this->id,
            'rating' => $this->rating(),
            'producer'=>$this->producer,
            'actors' => $this->actors,
            'isFav' => $this->isFav(),
            'genres' => GenreResource::collection($this->genres),
            'slug' => $this->slug
        ];
    }
}
