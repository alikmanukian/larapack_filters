<?php

namespace Adscom\LarapackFilters\Filters;

use Adscom\LarapackFilters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class NotNullFilter extends FilterAbstract
{
  public function filter(Builder $query, $value): Builder
  {
    return $query->when($value,
      fn($q) => $q->whereNotNull($this->getMainColumn())
    );
  }
}
