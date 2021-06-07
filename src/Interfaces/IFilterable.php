<?php

namespace Adscom\LarapackFilters\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface IFilterable
{
  public function scopeFilter(Builder $query, Request $request, array $filters = []): Builder;
  public function getFiltersClass(): string;
}
