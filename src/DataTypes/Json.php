<?php

namespace NoaPe\Beluga\DataTypes;

use Illuminate\Database\Schema\Blueprint;
use NoaPe\Beluga\DataType;

class Json extends DataType
{
    /**
     * Blueprint type.
     */
    public $blueprint_type = 'text';

    /**
     * Html input type.
     */
    public $input_type = 'json';

    /**
     * Set function.
     */
    public function set($value)
    {
        return json_encode($value);
    }

    /**
     * Get function.
     */
    public function get($value)
    {
        return json_decode($value);
    }
}
