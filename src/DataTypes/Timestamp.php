<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Timestamp extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'timestamp';

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
     * @return array
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();

        $rules[] = 'date';

        return $rules;
    }
}
