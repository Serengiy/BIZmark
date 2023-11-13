<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ActorFilter extends AbstractFilter
{

    public function key(): string
    {
        return 'actors';
    }

    public function apply(Builder $q): Builder
    {
        return $q->when($this->requestValue(), function (Builder $q){
            $values = $this->values();
            $q->whereHas('actors', function (Builder $subQuery) use ($values) {
                $subQuery->whereIn('name', $values);
            });
        });
    }

    public function values(): mixed
    {
        return explode(',', request('actors'));
    }
}
