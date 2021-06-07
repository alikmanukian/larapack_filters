<?php

namespace Adscom\LarapackFilters\Filters;

use Adscom\LarapackFilters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class PatternFilter extends FilterAbstract
{
  public function filter(Builder $query, $value): Builder
  {
    $keys = collect(
      array_merge(
        $this->args->get('keys', []),
        (array) $this->args->get('key', [])
      )
    );

    if ($keys->isEmpty()) {
      $keys->push($this->getMainColumn());
    }

    $query->where(function ($q) use ($keys, $value) {
      $keys->each(function ($key) use ($q, $value) {
        $this->caseInsensitiveSearch($q, $key, $value);
      });
    });

    return $query;
  }

  public static function getJsonColumnName(string $column, string $key): string
  {
    return "{$column}->>'{$key}'";
  }

  private function caseInsensitiveSearch(Builder $query, string $column, string $needle): Builder
  {
    if ($this->isMySql()) {
      return $query->orWhereRaw("LOWER({$column}) like ?", ["%".mb_strtolower($needle)."%"]);
    }

    return $query->orWhereRaw("{$column} ilike ?", ["%".mb_strtolower($needle)."%"]);
  }
}
