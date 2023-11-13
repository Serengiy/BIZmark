<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract  class AbstractFilter
{
    public function __invoke(Builder $q, $next)
    {
        $this->apply($q);
        $next($q);
    }
    abstract public function key(): string;
    abstract public function apply(Builder $q): Builder;
    abstract public function values(): mixed;

    public function requestValue(): mixed
    {
        if (request($this->key()) === "null"){
            return null;
        }
        return request($this->key());
    }
}
