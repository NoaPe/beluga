<?php

namespace NoaPe\Beluga\Http\Models;

use NoaPe\Beluga\Shell;

abstract class BasicShell extends Shell
{
    /**
     * Static function to get table name.
     */
    public static function getTableName()
    {
        return config('beluga.table_prefix').parent::getTableName();
    }

    /**
     * Static function to get a name of schema file.
     */
    public static function getSchemaFileName()
    {
        return __DIR__.'/../../../database/schemas/'.class_basename(get_called_class()).'Schema.json';
    }
}
