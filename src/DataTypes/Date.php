<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Date extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'date';

    /**
     * Html input type.
     */
    public $input_type = 'time';
}
