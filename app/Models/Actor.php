<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;
use PhpParser\Builder;

class Actor extends Model
{
    use HasFactory;

    protected $guarded=false;

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'actor_movie');
    }

}
