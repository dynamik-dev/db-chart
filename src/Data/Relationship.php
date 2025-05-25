<?php

namespace Dynamik\DbChart\Data;

use Dynamik\DbChart\Data\Enums\Relation;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

class Relationship extends Data
{
    public function __construct(
        public string|Model $from,
        public string|Model $to,
        public Relation $type,
    ) {}
}
