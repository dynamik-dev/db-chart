<?php

use Dynamik\DbChart\Transformers\ToMermaid;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $sql = file_get_contents(__DIR__.'/../tests/sqlite-schema.sql');

    // Split the SQL file into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        fn ($statement) => ! empty($statement)
    );

    // Execute each statement
    foreach ($statements as $statement) {
        DB::statement($statement);
    }
});

it('can test', function () {
    $toMermaid = app(ToMermaid::class);
    $schema = $toMermaid->handle();
    $expectedSchema = <<<'MERMAID'
erDiagram

posts ||--o{ comments : "has_many"
users ||--o{ comments : "has_many"
users ||--o{ posts : "has_many"
posts ||--o{ reactions : "has_many"
users ||--o{ reactions : "has_many"
users ||--o{ sessions : "has_many"
MERMAID;

    expect($schema)->toBe($expectedSchema);
});
