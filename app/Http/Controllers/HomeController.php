<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieMinifiedResource;
use App\Models\Actor;
use App\Models\Movie;
use App\Models\Producer;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $page = request('page') ?? 1;
        $producers = Producer::all();
        $actors = Actor::all();
        $moviesRaw = Movie::query()->filtered()->sorted()->paginate(config('pagination.catalog'), '*', 'page', $page);

        if(request('search')){
            $moviesRaw = Movie::query()->searched()->paginate(config('pagination.catalog'), '*', 'page', $page);
            return response()->json([
                'movies'=> MovieMinifiedResource::collection($moviesRaw),
                'meta' => [
                    'page' => $moviesRaw->currentPage(),
                    'isLastPage' => $moviesRaw->onLastPage()
                ]
            ]);
        }

        if(request('page')){
            return response()->json([
                'movies'=> MovieMinifiedResource::collection($moviesRaw),
                'meta' => [
                    'page' => $moviesRaw->currentPage(),
                    'isLastPage' => $moviesRaw->onLastPage()
                ]
            ]);
        }

        $movies = MovieMinifiedResource::collection($moviesRaw);
        return inertia('Movie/Index', compact('movies', 'producers', 'actors'));
    }
}
