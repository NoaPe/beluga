<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Text extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'text';

    /**
     * Html input type.
     */
    public $input_type = 'text';

    /**
     * Constructor
     *
     * @param  string  $name
     * @param  array  $shell
     */
    public function __construct($name, $shell)
    {
        parent::__construct($name, $shell);

        /**
         * If the scale setting of $data is set to medium or long, set the appropriate $blueprint_type and the $input_type.
         */
        if (isset($this->schema->settings->scale)) {
            switch ($this->schema->settings->scale) {
                case 'medium':
                    $this->blueprint_type = 'mediumText';
                    $this->input_type = 'textarea';
                    break;
                case 'long':
                    $this->blueprint_type = 'longText';
                    $this->input_type = 'textarea';
                    break;
            }
        }
    }
}
