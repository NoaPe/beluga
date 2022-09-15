<?php

namespace NoaPe\Beluga\Http\Models\Concerns;

use NoaPe\Beluga\Beluga;

trait HasSubGroups
{
    /**
     * Subgroups
     */
    public $groups;

    /**
     * Datas
     */
    public $datas;

    /**
     * Function who return the stdClass object of the schema.
     */
    public static function getRawSchema()
    {
        /**
         * Get the schema from the parent.
         */
        $schema = parent::getRawSchema();

        /**
         * Set groups property with a recursive call and use $group->name as $key.
         */
        if (isset($schema->groups) && is_array($schema->groups)) {
            $groups = new \stdClass();

            foreach ($schema->groups as $key => $group) {
                $groups->{$key} = $group::getRawSchema();
            }

            $schema->groups = $groups;
        }

        /**
         * Set datas property with a mapping and data getSchema function with the data name as key.
         */
        if (isset($schema->datas) && is_array($schema->datas)) {
            $datas = new \stdClass();

            foreach ($schema->datas as $key => $data) {
                $class = Beluga::getDataType($data->type);
                $datas->{$key} = $class;
            }

            $schema->datas = $datas;
        }

        return $schema;
    }

    /**
     * Call register function of each datas of the table.
     *
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return void
     */
    public function registerDatas($shell)
    {
        // Call register function of each data in $this->datas
        foreach ($this->datas as $data) {
            $data->register($shell);
        }

        // Call registerDatas for each group
        foreach ($this->groups as $group) {
            $group->registerDatas($shell);
        }
    }
}
