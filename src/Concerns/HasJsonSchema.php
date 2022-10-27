<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Http\Models\Data;
use NoaPe\Beluga\Http\Models\Group;
use NoaPe\Beluga\Http\Models\Table;

trait HasJsonSchema
{
    /**
     * Static function for get a name of schema file.
     */
    public static function getJsonSchemaFileName($shell, $folder)
    {
        if (method_exists($shell, 'getJsonSchemaFileName')) {
            return $shell->getJsonSchemaFileName();
        }

        return config('beluga.schema_path').'/'
            .($folder ? $folder.'/' : '')
            .class_basename($shell).'Schema.json';
    }

    /**
     * Static function to get raw schema information.
     */
    protected static function getRawSchema($shell, $folder)
    {
        /**
         * Get schema information from Json file.
         */
        $file = static::getJsonSchemaFileName($shell, $folder);
        $data = new \stdClass();

        if (file_exists($file)) {
            $data = file_get_contents($file);
        } else {
            throw new \Exception('Schema file not found: '.$file);
        }

        return json_decode($data);
    }

    protected static function getDatasSchemaFromArray($datas)
    {
        $schema = new \stdClass();

        foreach ($datas as $key => $data) {
            $data->name = $key;
            $data = json_decode(json_encode($data), true);
            $schema->{$key} = new Data((array) $data);
        }

        return $schema;
    }

    protected static function getGroupsSchemaFromArray($groups)
    {
        $schema = new \stdClass();

        foreach ($groups as $key => $value) {
            $schema->{$key} = self::getGroupSchemaFromArray($value, $key);
        }

        return $schema;
    }

    /**
     * Recursive static function for get the schema of group with instanciate data types.
     *
     * @param  mixed  $group
     * @return \NoaPe\Beluga\Http\Models\Group
     */
    protected static function getGroupSchemaFromArray($group, $name)
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
            $schema->groups = self::getGroupsSchemaFromArray($groups);
        }

        if (isset($datas)) {
            $schema->datas = self::getDatasSchemaFromArray($datas);
        }

        return $schema;
    }

    /**
     * Function who take raw schema array and return a schema array with the correct instanciate data types.
     *
     * @return Table
     */
    protected static function getSchemaFromJson($shell, $folder)
    {
        /**
         * Get raw schema information.
         */
        $schema = self::getRawSchema($shell, $folder);

        $schema->name = $shell->getName();

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
            $table->datas = self::getDatasSchemaFromArray($datas);
        } else {
            $table->datas = new \stdClass();
        }

        if (isset($groups)) {
            $table->groups = self::getGroupsSchemaFromArray($groups);
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
    public static function hasJsonSchema($shell, $folder)
    {
        return file_exists(self::getJsonSchemaFileName($shell, $folder));
    }
}
