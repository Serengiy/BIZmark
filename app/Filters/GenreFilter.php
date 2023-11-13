<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class GenreFilter extends AbstractFilter
{

    public function key(): string
    {
        return 'genre';
    }

    public function apply(Builder $q): Builder
    {
        return $q->when($this->requestValue(), function (Builder $q) {
            $values = $this->values();
            $q->whereRelation('genres', 'title', $values);
        });
    }

    public function values(): mixed
    {
        return $this->requestValue();
    }
}
