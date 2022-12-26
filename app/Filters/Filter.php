<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use ReflectionClass;

abstract class Filter
{
    protected Builder $builder;

    /** @var array<static> */
    protected array $filters;

    public function __construct(protected Request $request)
    {
        $reflection = new ReflectionClass(static::class);

        foreach ($reflection->getMethods() as $method) {
            if ($method->class == static::class) {
                $this->filters[] = mb_strtolower(mb_strcut($method->getName(), 2));
            }
        }
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            $method = 'by' . ucfirst($filter);
            $this->$method($value);
        }

        return $this->builder;
    }

    public function getFilters(): array
    {
        return $this->request->only($this->filters);
    }
}
