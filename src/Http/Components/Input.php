<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\ShellRenderer;

class Input extends ComponentWithShell
{
    public $prefix;

    public $name;

    public function __construct($shell, $prefix = '', $name, $internal = false)
    {
        parent::__construct($shell, $internal);

        $this->prefix = $prefix;
        $this->name = $name;
    }

    public function render()
    {
        /**
         * Use the ShellRenderer to render the input.
         */
        return ShellRenderer::input($this->shell, $this->prefix, $this->name, $this->internal);
    }
}