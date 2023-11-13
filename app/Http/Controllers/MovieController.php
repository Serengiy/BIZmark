<?php

namespace App\Http\Controllers;

use App\Http\Requests\Movie\UpdateImagesRequest;
use App\Http\Resources\MovieMinifiedResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function show(Movie $movie)
    {
        $movie = MovieResource::make($movie)->resolve();

        return inertia('Movie/Show', compact('movie'));
    }

    public function toggleFav(Movie $movie)
    {
        $movie->favorites()->toggle(auth()->id());
        $movie = MovieMinifiedResource::make($movie)->resolve();
        return response()->json([
            'movie' => $movie
        ]);
    }

    public function edit(Movie $movie)
    {
        return inertia('Movie/Edit', compact('movie'));
    }

    public function update(Movie $movie, UpdateImagesRequest $request)
    {
        $validatedData = $request->validated();
        $preview = Arr::pull($validatedData, 'mainFile');
        $path =  Storage::url($preview->storePublicly('images/poster'));
        $movie->update([
            'preview' => $path
        ]);

        $movie->gallery()->delete();

        foreach ($validatedData as $item){
            $path =  Storage::url($item->storePublicly('images/gallery'));
            $movie->gallery()->create([
                'url' =>$path
            ]);
        }
        return response()->json([
            'message' => 'success'
        ]);
    }
}
