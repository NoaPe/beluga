<?php

namespace NoaPe\Beluga\Http\Models;

use NoaPe\Beluga\Beluga;
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
    public static function getJsonSchemaFileName()
    {
        return __DIR__.'/../../../database/schemas/'.class_basename(get_called_class()).'Schema.json';
    }

    /**
     * Function who return the stdClass object of the schema.
     */
    public static function getRawSchema()
    {
        $schema = new \stdClass();

        $parent_schema = parent::getRawSchema();

        /**
         * Set properties from the model with loop only if the settings invisible is not true.
         */
        foreach ($parent_schema as $key => $value) {
            if ($value->settings->invisible ?? false) {
                continue;
            }

            $schema->{$key} = $parent_schema->{$key};
        }

        return $schema;
    }

    /**
     * Static function for register itself to the ShellComponentProvider
     */
    public static function register()
    {
        Beluga::registerInternalShell(get_called_class());
    }
}
