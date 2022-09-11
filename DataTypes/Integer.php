<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Integer extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'integer';

    public function addToBlueprint($blueprint)
    {
        /**
         * If the scale setting is set to big or tiny, set the appropriate $blueprint_type.
         */
        if ($this->scale == 'big') {
            $this->blueprint_type = 'bigInteger';
        } elseif ($this->scale == 'tiny') {
            $this->blueprint_type = 'tinyInteger';
        }

        /**
         * Get the column from the parent function.
         */
        $column = parent::addToBlueprint($blueprint);

        /**
         * If the unsigned setting is set and true, add it to the column.
         */
        if (isset($this->settings['unsigned']) && $this->settings['unsigned']) {
            $column->unsigned();
        }

        return $column;
    }

}
