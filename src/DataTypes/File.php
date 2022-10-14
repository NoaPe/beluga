<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class File extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'string';

    /**
     * Html input type.
     */
    public $input_type = 'file';
}
