<?php

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genre_movies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Genre::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Movie::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_movies');
    }
};
