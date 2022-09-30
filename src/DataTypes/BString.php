<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class BString extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'string';

    
    /**
     * Function for get the validation rules.
     * 
     * @return string
     */
    public function getValidationRules()
    {
        $rules = parent::getValidationRules();

        $rules .= '|string';

        return $rules;
    }

}
