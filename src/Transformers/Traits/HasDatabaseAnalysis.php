<?php

namespace Dynamik\DbChart\Transformers\Traits;

use Dynamik\DbChart\Data\DbSchema;
use Dynamik\DbChart\Data\Enums\Relation;
use Dynamik\DbChart\Data\Relationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait HasDatabaseAnalysis
{
    /**
     * Returns a map of table names to model classes.
     *
     * @return array<string, string>
     */
    protected function modelTableMap(): array
    {
        return collect(File::allFiles(base_path('app')))
            ->map(fn ($file) => 'App\\'.str_replace(
                ['/', '.php'],
                ['\\', ''],
                $file->getRelativePathname()
            ))
            ->filter(fn ($class) => class_exists($class))
            ->filter(fn ($class) => is_subclass_of($class, Model::class))
            ->mapWithKeys(fn ($class) => [(new $class)->getTable() => $class])
            ->toArray();
    }

    /**
     * Get all database tables.
     *
     * @return array<string>
     */
    protected function getTables(): array
    {
        return collect(Schema::getTables())->pluck('name')->toArray();
    }

    /**
     * Get all relationships between tables.
     *
     * @return Collection<int, Relationship>
     */
    protected function getRelationships(): Collection
    {
        $modelMap = $this->modelTableMap();
        $tables = $this->getTables();

        return collect($tables)->flatMap(function ($table) use ($modelMap, $tables) {
            // Get explicit foreign key relationships
            $explicitRelations = collect(Schema::getForeignKeys($table))
                ->map(function ($foreignKey) use ($modelMap, $table) {
                    $parentTable = $foreignKey['foreign_table'];
                    $childTable = $table;

                    return [
                        'from' => class_basename(data_get($modelMap, $parentTable, $parentTable)),
                        'to' => class_basename(data_get($modelMap, $childTable, $childTable)),
                        'type' => Relation::HAS_MANY,
                    ];
                });

            // Get implicit relationships based on naming convention
            $implicitRelations = collect(Schema::getColumns($table))
                ->filter(fn ($column) => str_ends_with($column['name'], '_id'))
                ->map(function ($column) use ($modelMap, $table, $tables) {
                    $potentialParentTable = Str::plural(Str::singular(str_replace('_id', '', $column['name'])));

                    // Check if the potential parent table exists
                    if (! in_array($potentialParentTable, $tables)) {
                        return null;
                    }

                    return [
                        'from' => class_basename(data_get($modelMap, $potentialParentTable, $potentialParentTable)),
                        'to' => class_basename(data_get($modelMap, $table, $table)),
                        'type' => Relation::HAS_MANY,
                    ];
                })
                ->filter();

            return $explicitRelations->merge($implicitRelations);
        })
            ->unique(fn ($rel) => $rel['from'].$rel['to'])
            ->sortBy(fn ($rel) => $rel['to'].$rel['from'])
            ->map(fn ($rel) => new Relationship($rel['from'], $rel['to'], $rel['type']));
    }

    public function getDbSchema(): DbSchema
    {

        return new DbSchema($this->getRelationships());
    }
}
