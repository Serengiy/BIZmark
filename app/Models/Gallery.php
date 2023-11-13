<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'galleries';

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
