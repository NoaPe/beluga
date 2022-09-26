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

    /**
     * Generate seed value.
     * 
     * @return string
     */
    public function generateSeedValue()
    {
        return date('H:i:s', mt_rand(0, time()));
    }
}
