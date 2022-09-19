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
    protected function getSchemaFromInternalJson()
    {
        return $this->schemaWithDataInstantiation();
    }

    /**
     * Schema with data instantiation.
     * 
     * @return \stdClass
     */
    public function schemaWithDataInstantiation()
    {
        $schema = $this->getRawSchema();

        $schema = $this->groupWithDataInstantiation($schema);

        return $schema;
    }

    /**
     * Group with data instantiation.
     * 
     * @return \stdClass
     */
    public function groupWithDataInstantiation($group)
    {
        if (isset($group->datas)) {
            $group->datas = $this->datasWithDataInstantiation($group->datas);
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $key => $subgroup) {
                $group->groups->{$key} = $this->groupWithDataInstantiation($subgroup);
            }
        }

        return $group;
    }

    /**
     * Datas with data instatiation.
     * 
     * @return \stdClass
     */
    public function datasWithDataInstantiation($datas)
    {
        foreach ($datas as $key => $data) {
            $datas->{$key} = new class($data, $this, $key) {
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