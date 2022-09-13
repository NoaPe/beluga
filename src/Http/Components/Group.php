<?php

namespace NoaPe\Beluga\Http\Components;

use Illuminate\View\Component;
use NoaPe\Beluga\ShellRenderer;

class Group extends Component
{
    public $group;

    public $prefix;

    public $internal;

    public function __construct($group, $prefix, $internal = false)
    {
        $this->group = $group;
        $this->prefix = $prefix;
        $this->internal = $internal;
    }

    public function render()
    {
        /**
         * Use the ShellRenderer to render the group.
         */
        return ShellRenderer::group($this->group, $this->prefix, $this->internal);
    }
}