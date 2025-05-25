<?php

namespace Dynamik\DbChart\Transformers;

use Dynamik\DbChart\Data\Relationship;
use Dynamik\DbChart\Transformers\Traits\HasDatabaseAnalysis;
use Illuminate\Database\Connection;
use Illuminate\Support\Collection;

class ToMermaid
{
    use HasDatabaseAnalysis;

    public function __construct(
        public Connection $connection,
    ) {}

    /**
     * Format relationships for Mermaid syntax.
     *
     * @param  Collection<int, Relationship>  $relationships
     */
    protected function formatRelationshipsForMermaid(Collection $relationships): string
    {

        return collect($relationships)
            ->map(function (Relationship $rel) {
                return "{$rel->from} ||--o{ {$rel->to} : \"{$rel->type->value}\"";
            })
            ->join("\n");
    }

    public function handle(): string
    {

        $formattedRelationships = $this->formatRelationshipsForMermaid($this->getDbSchema()->relationships);

        return <<<MERMAID
erDiagram

{$formattedRelationships}
MERMAID;
    }
}
