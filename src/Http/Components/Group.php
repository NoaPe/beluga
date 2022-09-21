<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\ShellRenderer;

class Group extends ComponentWithShell
{
    public $name;

    public $prefix;

    public $internal;

    public function __construct($shell, $name, $prefix = '', $internal = false)
    {
        parent::__construct($shell, $internal);

        $this->name = $name;
        $this->prefix = $prefix;
        $this->internal = $internal;
    }

    public function render()
    {
        /**
         * Use the ShellRenderer to render the group.
         */
        return ShellRenderer::group($this->shell, $this->name, $this->prefix, $this->internal);
    }
}
