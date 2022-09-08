<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Data extends BasicShell
{
    use HasFactory;

    /**
     * Static function for set the table name to "datas" with the config prefix.
     */
    public static function getTableName()
    {
        return config('beluga.table_prefix').'datas';
    }

    /**
     * Belongs to relation Group model if parent_is_group is true, Table model if parent_is_group is false.
     */
    public function parent()
    {
        return $this->belongsTo(
            $this->parent_is_group ? Group::class : Table::class,
            'parent_id'
        );
    }
}
