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
    public function getSchemaFromDatabase()
    {
        $table = Table::where('name', $this->table)->first();

        if (! $this->table) {
            throw new \Exception('Table "'.$this->table.'" not found in the database please migrate it.');
        }

        return $table;
    }
}