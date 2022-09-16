<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Http\Models\Data;

trait HasJsonSchema
{
    /**
     * Json schema information array.
     */
    protected $raw_schema;

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
    protected static function rawSchema()
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
     * Return raw schema.
     * 
     * @return \stdClass
     */
    protected function getRawSchema()
    {
        if ($this->raw_schema) {
            return $this->raw_schema;
        }

        $this->raw_schema = get_called_class()::rawSchema();

        return $this->raw_schema;
    }

    /**
     * Static function who take raw schema array and return a schema array with the correct instanciate data types.
     */
    protected function getJsonSchema()
    {
        /**
         * Get raw schema information.
         */
        $schema = $this->getRawSchema();

        return $this->getGroupSchema($schema);
    }

    /**
     * Test if the JSON Schema file exists
     */
    public static function hasJsonSchema()
    {
        return file_exists(get_called_class()::getJsonSchemaFileName());
    }

    /**
     * Get a data raw schema from a key.
     * 
     * @param  string  $key
     */
    public function getDataSchema($key)
    {
        $schema = $this->getRawSchema();

        return self::getDataSchemaFromGroup($key, $schema);
    }

    /**
     * Get a data raw schema from a key.
     */
    public static function getDataSchemaFromGroup($key, $group)
    {
        if (isset($group->datas)) {
            foreach ($group->datas as $data) {
                if ($data->name == $key) {
                    return $data;
                }
            }
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                $data = self::getDataSchemaFromGroup($key, $group2);

                if ($data !== null) {
                    return $data;
                }
            }
        }

        return null;
    }

    
}
