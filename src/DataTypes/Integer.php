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
     * @param string $name
     * @param array $data
     */
    public function __construct($name, $data)
    {
        parent::__construct($name, $data);
        
        /**
         * If the scale setting is set to big or tiny, set the appropriate $blueprint_type.
         */
        if (isset($this->settings->scale)) {
            switch ($this->settings->scale) {
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
        if (isset($this->settings->unsigned) && $this->settings->unsigned) {
            $column->unsigned();
        }

        return $column;
    }
}
