<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use App\Traits\Models\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;
    use HasSlug;
    protected $guarded = false;

    public function movie(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'genre_movies');
    }

    static function getOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugFrom('title')
            ->saveSlugsTo('slug');
    }
}
