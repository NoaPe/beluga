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
     * @param  array  $datas
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return \stdClass
     */
    protected static function datasWithDataInstantiation($datas, $shell)
    {
        foreach ($datas as $key => $data) {
            $datas->{$key} = new class($data, $shell, $key)
            {
                /**
                 * Type of data.
                 * 
                 * @var \NoaPe\Beluga\DataType
                 */
                protected $type;

                /**
                 * Shell
                 * 
                 * @var \NoaPe\Beluga\Shell
                 */
                protected $shell;

                /**
                 * Name
                 * 
                 * @var string
                 */
                protected $name;

                /**
                 * Constructor.
                 * 
                 * @param  \stdClass  $data
                 * @param  \NoaPe\Beluga\Shell  $shell
                 * @param  string  $name
                 * @return void
                 */
                public function __construct($data, $shell, $name)
                {
                    foreach ($data as $key => $value) {
                        $this->{$key} = $value;
                    }

                    $this->type = Beluga::getDataType($data->type);
                    $this->shell = $shell;
                    $this->name = $name;
                }

                /**
                 * Get type.
                 * 
                 * @return \NoaPe\Beluga\DataType
                 */
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
