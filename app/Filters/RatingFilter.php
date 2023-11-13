<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class RatingFilter extends AbstractFilter
{

    public function key(): string
    {
        return 'rating';
    }

    public function apply(Builder $q): Builder
    {
        $values = explode(',',$this->requestValue());
        return  $q->when($this->requestValue(), function (Builder $q) use ($values) {
            $q->whereHas('review', function (Builder $subQuery) use ($values) {
                $subQuery->selectRaw('AVG(rating) as average_rating')
                    ->groupBy('movie_id')
                    ->havingRaw('average_rating >= ? and average_rating <= ?', [(int) $values[0], (int) $values[1]]);
            });
        });

    }

    public function values(): mixed
    {

        return $this->requestValue();
    }
}
