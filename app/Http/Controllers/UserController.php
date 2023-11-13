<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieMinifiedResource;
class UserController extends Controller
{
    public function index()
    {
        $page = request('page') ?? 1;
        $moviesRaw = auth()->user()->favorites()->paginate(config('pagination.favorites'), ['*'], 'page', $page);
        $movies = MovieMinifiedResource::collection($moviesRaw);

        if(request('page')){

            return response()->json([
                'movies'=> $movies,
                'meta' => [
                    'page' => $moviesRaw->currentPage(),
                    'isLastPage' => $moviesRaw->onLastPage()
                ]
            ]);
        }
        return inertia('User/FavoriteMovie', compact('movies'));
    }
}
