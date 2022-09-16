<?php

namespace NoaPe\Beluga\DataTypes\Geo;

use Illuminate\Database\Schema\Blueprint;
use NoaPe\Beluga\DataType;
use NoaPe\Beluga\Helpers\Point;

abstract class Position extends DataType
{
    /**
     * Blueprint type.
     */
    public $blueprint_type = 'string';

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
        return parent::set($value->lat.':'.$value->lng);
    }

    /**
     * Get function.
     */
    public function get()
    {
        $value = parent::get();

        $value = explode(':', $value);

        return new Point($value[0], $value[1]);
    }

    /**
     * Render input.
     */
    public function renderInput()
    {
        return view('beluga::components.inputs.'.$this->input_type, [
            'data' => $this,
        ]);
    }
}
