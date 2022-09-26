<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class BFloat extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'float';

    /**
     * Add to blueprint.
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $blueprint
     * @return mixed
     */
    public function addToBlueprint($blueprint)
    {
        /**
         * Get the column from the parent function.
         */
        $column = parent::addToBlueprint($blueprint);

        /**
         * If the unsigned setting is set and true, add it to the column.
         */
        if (isset($this->schema->settings->unsigned) && $this->schema->settings->unsigned) {
            $column->unsigned();
        }

        /**
         * If the precision setting is set, add it to the column.
         */
        if (isset($this->schema->settings->precision)) {
            $column->precision($this->schema->settings->precision);
        }

        return $column;
    }

    /**
     * Generate seed value.
     *
     * @return float
     */
    public function generateSeedValue()
    {
        return mt_rand(0, 1000000) / 100;
    }
}
