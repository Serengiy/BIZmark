<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment' => $this->comment,
            'rating' => $this->rating,
            'user' => UserResource::make($this->user)->resolve(),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
