<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Http\Models\Data;
use NoaPe\Beluga\Http\Models\Group;
use NoaPe\Beluga\Http\Models\Table;
use NoaPe\Beluga\Beluga;

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
        return config('beluga.schema_path').'/'.class_basename(static::class).'Schema.json';
    }

    /**
     * Static function to get raw schema information.
     */
    protected static function rawSchema()
    {
        /**
         * Get schema information from Json file.
         */
        $file = static::getJsonSchemaFileName();
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

        $this->raw_schema = static::rawSchema();

        return $this->raw_schema;
    }
    
    protected function getDatasSchemaFromArray($datas)
    {
        $schema = new \stdClass();

        foreach ($datas as $key => $data) {
            $data->name = $key;
            $data = json_decode(json_encode($data), true);
            $schema->{$key} = Data::firstOrNew((array) $data);
        }

        return $schema;
    }

    protected function getGroupsSchemaFromArray($groups)
    {
        
        $schema = new \stdClass();

        foreach ($groups as $key => $value) {
            $schema->{$key} = $this->getGroupSchemaFromArray($value, $key);
        }

        return $schema;
    }

    /**
     * Recursive static function for get the schema of group with instanciate data types.
     *
     * @param  mixed  $group
     * @return \NoaPe\Beluga\Http\Models\Group
     */
    protected function getGroupSchemaFromArray($group, $name)
    {
        $group->name = $name;

        /**
         * Remove the datas and groups from the schema.
         */
        if (isset($group->datas)) {
            $datas = $group->datas;
            unset($group->datas);
        }

        if (isset($group->groups)) {
            $groups = $group->groups;
            unset($group->groups);
        }

        $schema = new Group((array) $group);
        
        if (isset($groups)) {
            $schema->groups = $this->getGroupsSchemaFromArray($groups);
        }

        if (isset($datas)) {
            $schema->datas = $this->getDatasSchemaFromArray($datas);
        }

        return $schema;
    }

    /**
     * Function who take raw schema array and return a schema array with the correct instanciate data types.
     * 
     * @return Table
     */
    protected function getSchemaFromJson()
    {
        /**
         * Get raw schema information.
         */
        $schema = $this->getRawSchema();

        $schema->name = $this->getName();

        /**
         * Remove the datas and groups from the schema.
         */
        if (isset($schema->datas)) {
            $datas = $schema->datas;
            unset($schema->datas);
        }

        if (isset($schema->groups)) {
            $groups = $schema->groups;
            unset($schema->groups);
        }

        $table = new Table((array) $schema);

        if (isset($datas)) {
            $table->datas = $this->getDatasSchemaFromArray($datas);
        } else {
            $table->datas = new \stdClass();
        }

        if (isset($groups)) {
            $table->groups = $this->getGroupsSchemaFromArray($groups);
        } else {
            $table->groups = new \stdClass();
        }

        return $table;
    }

    /**
     * Test if the JSON Schema file exists
     * 
     * @return bool
     */
    public static function hasJsonSchema()
    {
        return file_exists(static::getJsonSchemaFileName());
    }
}
