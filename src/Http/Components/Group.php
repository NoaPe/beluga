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
         * Return the group view with the group and the prefix.
         */
        return view('beluga::components.group')->with([
            'group' => $this->shell->getGroup($this->name),
            'name' => $this->name,
            'prefix' => $this->name.'-'.$this->prefix,
            'internal' => $this->internal,
        ]);
    }
}
