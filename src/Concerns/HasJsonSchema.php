<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Beluga;
use NoaPe\Beluga\Http\Models\Data;
use NoaPe\Beluga\Http\Models\Group;

trait HasJsonSchema
{
    /**
     * Static function for get a name of schema file.
     */
    public static function getJsonSchemaFileName()
    {
        return config('beluga.schema_path').'/'.class_basename(get_called_class()).'Schema.json';
    }

    /**
     * Static function to get raw schema information.
     */
    protected static function getRawSchema()
    {
        /**
         * Get schema information from Json file.
         */
        $file = get_called_class()::getJsonSchemaFileName();
        $data = new \stdClass();

        if (file_exists($file)) {
            $data = file_get_contents($file);
        } else {
            throw new \Exception('Schema file not found: '.$file);
        }

        return json_decode($data);
    }


    /**
     * Static function who take raw schema array and return a schema array with the correct instanciate data types.
     */
    protected static function getJsonSchema()
    {
        /**
         * Get raw schema information.
         */
        $schema = get_called_class()::getRawSchema();

        return get_called_class()::getGroupSchema($schema);
    }

    /**
     * Test if the JSON Schema file exists
     */
    public static function hasJsonSchema()
    {
        return file_exists(get_called_class()::getJsonSchemaFileName());
    }
}
