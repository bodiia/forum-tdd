<?php

declare(strict_types=1);

namespace App\Builders;

use App\Filters\ThreadsFilter;
use Illuminate\Database\Eloquent\Builder;

final class ThreadBuilder extends Builder
{
    public function withFilters(ThreadsFilter $filters): ThreadBuilder|Builder
    {
        return $filters->apply($this);
    }
}
