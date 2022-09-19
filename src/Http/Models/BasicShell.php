<?php

namespace NoaPe\Beluga\Http\Models;

use NoaPe\Beluga\Shell;

abstract class BasicShell extends Shell
{
    /**
     * Table definition bypass
     */
    protected $table_bypass = true;

    /**
     * Schema origin
     *
     * @var string
     */
    protected $schema_origin = 'InternalJson';

    /**
     * Static function to get a name of schema file.
     */
    public static function getJsonSchemaFileName()
    {
        return __DIR__.'/../../../database/schemas/'.class_basename(get_called_class()).'Schema.json';
    }

    /**
     * Static function to get a name of table.
     */
    public static function getTableName()
    {
        return config('beluga.table_prefix').parent::getTableName();
    }
}
