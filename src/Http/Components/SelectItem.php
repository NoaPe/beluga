<?php

namespace NoaPe\Beluga\Http\Components;

class SelectItem extends BasicComponent
{
    public $value;

    public $text;

    protected $view = 'beluga::components.inputs.select-item';

    /**
     * Constructor
     */
    public function __construct($value, $text)
    {
        $this->value = $value;
        $this->text = $text;
    }
}
