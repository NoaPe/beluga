<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use NoaPe\Beluga\Shell;
use Illuminate\Support\Str;

class Data extends Shell
{
    use HasFactory;

    /**
     * Static function to get table name.
     */
    public static function getTableName()
    {
        return config('beluga.table_prefix').'datas';
    }

    /**
     * Static function to get a name of schema file.
     */
    public static function getSchemaFileName()
    {
        return __DIR__.'/../../../database/schemas/DataSchema.json';
    }
}