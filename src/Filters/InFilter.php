<?php

namespace Adscom\LarapackFilters\Filters;

use Adscom\LarapackFilters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class InFilter extends FilterAbstract
{
  public function filter(Builder $query, $value): Builder
  {
    return $query->when($value,
      fn($q) => $q->whereIn($this->getMainColumn(), $value)
    );
  }
}
