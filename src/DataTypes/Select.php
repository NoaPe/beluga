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

    /**
     * Options
     */
    public $options = [];

    /**
     * Constructor
     * 
     * @param \NoaPe\Beluga\Shell $shell
     * @param string $name
     * @return void
     */
    public function __construct($shell, $name)
    {
        parent::__construct($shell, $name);

        $this->options = $this->schema->settings->options;
    }


    /**
     * Render input.
     */
    public function renderInput()
    {
        return view('beluga::components.inputs.'.$this->input_type)->with([
            'data' => $this->schema,
            'name' => $this->name,
            'options' => $this->options,
        ]);
    }

    /**
     * Generate seed value.
     * 
     * @return string
     */
    public function generateSeedValue()
    {
        $options = array_keys((array) $this->options);

        return $options[rand(0, count($options) - 1)];;
    }
}
