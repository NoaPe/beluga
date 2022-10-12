<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Beluga;
use NoaPe\Beluga\Http\Models\Data;

trait HasInternalJsonSchema
{
    /**
     * Function who take raw schema array and return a schema array with the correct instanciate data types.
     *
     * @return \stdClass
     */
    protected static function getSchemaFromInternalJson($shell)
    {
        return self::schemaWithDataInstantiation($shell);
    }

    /**
     * Schema with data instantiation.
     *
     * @return \stdClass
     */
    protected static function schemaWithDataInstantiation($shell)
    {
        $schema = self::getRawSchema($shell);

        $schema = self::groupWithDataInstantiation($schema, $shell);

        return $schema;
    }

    /**
     * Group with data instantiation.
     *
     * @return \stdClass
     */
    protected static function groupWithDataInstantiation($group, $shell)
    {
        if (isset($group->datas)) {
            $group->datas = self::datasWithDataInstantiation($group->datas, $shell);
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $key => $subgroup) {
                $group->groups->{$key} = self::groupWithDataInstantiation($subgroup, $shell);
            }
        }

        return $group;
    }

    /**
     * Datas with data instatiation.
     *
     * @return \stdClass
     */
    protected static function datasWithDataInstantiation($datas, $shell)
    {
        foreach ($datas as $key => $data) {
            $datas->{$key} = new class($data, $shell, $key)
            {
                protected $type = null;

                protected $shell;

                protected $name;

                public function __construct($data, $shell, $name)
                {
                    foreach ($data as $key => $value) {
                        $this->{$key} = $value;
                    }

                    $this->type = Beluga::getDataType($data->type);
                    $this->shell = $shell;
                    $this->name = $name;
                }

                public function getType()
                {
                    $class = $this->type;

                    return new $class($this->name, $this->shell);
                }
            };
        }

        return $datas;
    }
}
