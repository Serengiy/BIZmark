<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use App\Traits\Models\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class Movie extends Model
{
    use HasFactory;
    use HasSlug;
    protected $casts =[
      'released_at' => 'date'
    ];
    protected $guarded = false;

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_movies');
    }

    public function review(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_movie');
    }

    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }



    public function rating(): int
    {
        $reviews = $this->review;
        if ($reviews->count() > 0) {
            $totalRating = $reviews->sum('rating');
            $averageRating = $totalRating / $reviews->count();
            return round($averageRating);
        }
        return 0;
    }


    static function getOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopeFiltered(Builder $query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function isFav():bool
    {
        if(!auth()){
            return false;
        }
        return $this->belongsToMany(User::class, 'favorites')->where('user_id', auth()->id())->exists();
    }

    public function scopeSorted(Builder $query)
    {
        $query->when(request('sort'), function (Builder $q){
            $sort = request()->str('sort');
            $direction = $sort->contains('-') ? 'ASC' : 'DESC';
            $sortBy = $sort->remove('-');
            switch ($sortBy){
                case 'released_at':
                    $q->orderBy((string) $sortBy, $direction);
                    break;
                case 'rating':
                    $q->select(['movies.*'])
                        ->join('reviews', 'movies.id', '=', 'reviews.movie_id')
                        ->selectRaw('AVG(reviews.rating) as average_rating')
                        ->groupBy('movies.id')
                        ->orderBy('average_rating', $direction);
                    break;
            }

        });
    }

    public function scopeSearched(Builder $query)
    {
        $searchTerm = request('search');

        $query->where(function ($query) use ($searchTerm) {
            $query->where('description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('title', 'LIKE', '%' . $searchTerm . '%');
        });
    }
}
