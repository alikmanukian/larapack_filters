<?php

namespace Adscom\LarapackFilters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
  public function scopeFilter(Builder $query, Request $request, array $filters = []): Builder
  {
    $class = $this->getFiltersClass();
    return (new $class($request))->add($filters)->filter($query);
  }
}
