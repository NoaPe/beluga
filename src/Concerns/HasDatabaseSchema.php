<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Http\Models\Table;

trait HasDatabaseSchema
{
    /**
     * Get schema from database.
     *
     * @return  Table
     */
    public static function getSchemaFromDatabase($shell)
    {
        $table = Table::where('name', $shell->table)->first();

        if (! $shell->table) {
            throw new \Exception('Table "'.$shell->table.'" not found in the database please migrate it.');
        }

        return $table;
    }
}
