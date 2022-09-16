<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Select extends DataType
{
    /**
     * Blueprint type.
     */
    public $blueprint_type = 'string';
    
    /**
     * Html input type.
     */
    public $input_type = 'select';
}