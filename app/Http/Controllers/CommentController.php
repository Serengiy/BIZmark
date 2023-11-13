<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Movie;

class CommentController extends Controller
{
    public function store(Movie $movie, CommentStoreRequest $request)
    {
        $data = $request->validated();
        $review = $movie->review()->create([
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'user_id' => auth()->id()
        ]);
        return response()->json([
            'review' => ReviewResource::make($review)->resolve()
        ]);
    }
}
