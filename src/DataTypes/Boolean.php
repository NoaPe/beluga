<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Boolean extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'boolean';

    /**
     * Html input type.
     */
    public $input_type = 'checkbox';

    /**
     * Function for get the validation rules.
     *
     * @return array
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();

        $rules[] = 'boolean';

        return $rules;
    }

    /**
     * Generate seed value.
     *
     * @return bool
     */
    public function generateSeedValue()
    {
        return (bool) mt_rand(0, 1);
    }
}
