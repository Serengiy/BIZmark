<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Gallery;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Review;
use App\Models\Producer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Producer::factory(6)->create();
        Actor::factory(30)->create();
        Genre::factory(5)->create();

        Movie::factory(30)
            ->has(Review::factory(rand(3, 6))
                ->for(User::factory())
            )
            ->has(Gallery::factory(rand(3,5)))
            ->afterCreating(function (Movie $movie) {
                // Get random actors and attach them to the movie
                $randomActors = Actor::inRandomOrder()->limit(rand(3, 4))->get();
                $randomGenres = Genre::inRandomOrder()->limit(rand(1, 4))->get();
                $movie->actors()->attach($randomActors);
                $movie->genres()->attach($randomGenres);
            })->create();
    }
}
