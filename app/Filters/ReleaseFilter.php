<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ReleaseFilter extends AbstractFilter
{

    public function key(): string
    {
        return 'year';
    }

    public function apply(Builder $q): Builder
    {
        $years = $this->values();
        return  $q->when($this->requestValue(), function (Builder $q) use ($years) {
            $q->whereBetween('released_at', [$years[0], $years[1]]);
        });

    }

    public function values(): mixed
    {
        if(!$this->requestValue()){
            return null;
        }
        [$minYear, $maxYear] = explode(',', $this->requestValue());
        return [
            Carbon::createFromFormat('Y', $minYear)->subYears(),
            Carbon::createFromFormat('Y', $maxYear)->subYears(),

        ];
    }
}
