<?php

namespace Adscom\LarapackFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class FiltersAbstract
{
  protected Request $request;

  protected array $filters = [];

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function filter(Builder $query): Builder
  {
    foreach ($this->getFilters() as $filter => $value) {
      $this->resolveFilter($filter)->filter($query, $value);
    }

    return $query;
  }

  abstract public function filters(): array;

  public function getFilters(): array
  {
    return $this->filterFilters(array_merge($this->filters(), $this->filters));
  }

  protected function filterFilters($filters): array
  {
    return array_filter(
      collect($this->request->only(array_keys($filters)))
        ->mapWithKeys(
          function ($value, $key) {
            if (is_null($value)) {
              return [$key => null];
            }
            return [
              $key => is_numeric($value)
                ? (($value == (int) $value) ? (int) $value : (float) $value)
                : ($value === 'null' ? null : $value)
            ];
          }
        )->toArray(),
      fn($item) => $item !== null && $item !== ''
    );
  }

  protected function resolveFilter($filter)
  {
    $config = $this->filters()[$filter];
    if (!is_array($config)) {
      $config = [
        'handler' => $config,
      ];
    }

    $config['param'] = $filter;

    return new $config['handler']($config);
  }

  public function add(array $filters): FiltersAbstract
  {
    $this->filters = array_merge($this->filters, $filters);

    return $this;
  }
}
