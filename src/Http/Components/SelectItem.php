<?php

namespace NoaPe\Beluga\Http\Components;

use Illuminate\View\Component;

class SelectItem extends BasicComponent
{
    public $value;

    public $text;

    protected $view = 'beluga::components.select-item';

    /**
     * Constructor
     */
    public function __construct($value, $text)
    {
        $this->value = $value;
        $this->text = $text;
    }
}
