<?php

namespace NoaPe\Beluga\DataTypes\Geo;

use Illuminate\Database\Schema\Blueprint;
use NoaPe\Beluga\DataType;
use NoaPe\Beluga\Helpers\Point;

class Position extends DataType
{
    /**
     * Blueprint type.
     */
    public $blueprint_type = 'string';

    /**
     * Input type
     */
    public $input_type = 'geo.position';

    /**
     * Constructor.
     */
    public function __construct($name, $shell)
    {
        parent::__construct($name, $shell);
    }

    /**
     * Function for add the column to the blueprint schema.
     *
     * @param  Blueprint  $blueprint
     * @return mixed
     */
    public function addToBlueprint($blueprint)
    {
        $column = parent::addToBlueprint($blueprint);

        // Do something...

        return $column;
    }

    /**
     * Set function.
     */
    public function set($value)
    {
        return $value->lat.':'.$value->lng;
    }

    /**
     * Get function.
     */
    public function get($value)
    {
        $value = explode(':', $value);

        return new Point($value[0], $value[1]);
    }

}
