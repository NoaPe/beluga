<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Http\Models\Data;
use NoaPe\Beluga\Http\Models\Group;
use NoaPe\Beluga\Http\Models\Table;
use NoaPe\Beluga\Beluga;

trait HasJsonSchema
{
    /**
     * Schema information array.
     *
     * @var array
     */
    public $schema;

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
     * Recursive static function for get the schema of group with instanciate data types.
     */
    protected static function getGroupSchema($group)
    {
        /**
         * If groups is set, replace each sub group with call to this function.
         */
        if (isset($group->groups)) {
            foreach ($group->groups as $key => $value) {
                $group->groups->{$key} = get_called_class()::getGroupSchema($value);
            }
        }

        /**
         * If data is set, replace each data with instanciate data type.
         */
        if (isset($group->datas)) {
            foreach ($group->datas as $key => $data) {
                $class = Beluga::getDataType($data->type);
                $group->datas->{$key} = new $class($key, $data);
            }
        }

        return $group;
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
     * Static function to get a validation rules in array format.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        $rules = [];

        $schema = get_called_class()::getJsonSchema();

        // TO DO

        return $rules;
    }

    /**
     * Function for get a data type from exploration of the schema.
     *
     * @param  string  $key
     * @param  array  $group
     * @return \Beluga\DataTypes\DataType
     */
    public function getDataType($key, $group = null)
    {
        if ($group == null) {
            $group = $this->schema;
        }

        if (isset($group->datas)) {
            foreach ($group->datas as $data) {
                if ($data->name == $key) {
                    return $data;
                }
            }
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                $data = $this->getDataType($key, $group2);

                if ($data) {
                    return $data;
                }
            }
        }

        return null;
    }

    /**
     * Test if the JSON Schema file exists
     */
    public static function hasJsonSchema()
    {
        return file_exists(get_called_class()::getJsonSchemaFileName());
    }
}