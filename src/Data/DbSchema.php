<?php

namespace Dynamik\DbChart\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class DbSchema extends Data
{
    /**
     * @param  \Illuminate\Support\Collection<int, \Dynamik\DbChart\Data\Relationship>  $relationships
     */
    public function __construct(
        public Collection $relationships,
    ) {}
}
