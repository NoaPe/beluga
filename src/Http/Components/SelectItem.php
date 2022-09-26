<?php

namespace NoaPe\Beluga\Http\Components;

use Illuminate\View\Component;

class SelectItem extends Component
{
    public $value;

    public $text;

    /**
     * Constructor
     */
    public function __construct($value, $text)
    {
        $this->value = $value;
        $this->text = $text;
    }

    public function render()
    {
        return view('beluga::components.inputs.select-item');
    }
}
