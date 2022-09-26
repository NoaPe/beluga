<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Integer extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'integer';

    /**
     * Constructor
     *
     * @param  string  $name
     * @param  \NoaPe\Beluga\Shell  $shell
     */
    public function __construct($name, $shell)
    {
        parent::__construct($name, $shell);

        /**
         * If the scale setting is set to big or tiny, set the appropriate $blueprint_type.
         */
        if (isset($this->schema->settings->scale)) {
            switch ($this->schema->settings->scale) {
                case 'big':
                    $this->blueprint_type = 'bigInteger';
                    break;
                case 'tiny':
                    $this->blueprint_type = 'tinyInteger';
                    break;
            }
        }
    }

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

        return $column;
    }

    /**
     * Generate seed value.
     *
     * @return int
     */
    public function generateSeedValue()
    {
        return mt_rand(0, 1000000);
    }
}
