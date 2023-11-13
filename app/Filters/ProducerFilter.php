<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProducerFilter extends AbstractFilter
{

    public function key(): string
    {
        return 'producers';
    }

    public function apply(Builder $q): Builder
    {
        return $q->when($this->requestValue(), function (Builder $q) {
            $values = $this->values();
            $q->whereRelation('producer', 'name', $values);
        });
    }

    public function values(): mixed
    {
        return $this->requestValue();
    }
}
