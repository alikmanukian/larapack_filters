<?php

namespace Adscom\LarapackFilters;

use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class FilterAbstract
{
  protected Collection $args;

  protected Collection $mappings;

  public function __construct(array $args = [])
  {
    $this->args = collect($args);
  }

  abstract public function filter(Builder $query, $value);

  public function mappings(): array
  {
    return [];
  }

  protected function resolveFilterValue($key)
  {
    return $this->mappings->get($key);
  }

  protected function isPostgres(): bool
  {
    return config('database.default') === 'pgsql';
  }

  protected function isMySql(): bool
  {
    return config('database.default') === 'mysql';
  }

  protected function getMainColumn(): string
  {
    return $this->args->get('key', $this->args->get('param'));
  }
}
