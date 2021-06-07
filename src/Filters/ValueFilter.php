<?php

namespace Adscom\LarapackFilters\Filters;

use Adscom\LarapackFilters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class ValueFilter extends FilterAbstract
{
  public function filter(Builder $query, $value): Builder
  {
    $operator = $this->args->get('operator', '=');

    return $query->where($this->getMainColumn(), $operator, $value);
  }
}
