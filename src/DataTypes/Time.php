<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Time extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'time';

    /**
     * Html input type.
     */
    public $input_type = 'time';
}
