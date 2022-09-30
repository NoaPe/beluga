<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class DateTime extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'datetime';

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
        return date('Y-m-d H:i:s', mt_rand(0, time()));
    }

    /**
     * Function for get the validation rules.
     * 
     * @return string
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();

        $rules .= '|date';

        return $rules;
    }
}
