<?php

namespace DynamikDev\DbChart;

use Dynamik\DbChart\Transformers\ToMermaid;
use Illuminate\Database\Connection;

class DbChart
{
    public ToMermaid $toMermaid;

    public function __construct(
        public Connection $connection,
    ) {}

    public function toMermaid(): string
    {
        return $this->toMermaid->handle();
    }
}
