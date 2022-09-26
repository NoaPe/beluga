<?php

namespace NoaPe\Beluga\Http\Components;

class Group extends ComponentWithShell
{
    public $name;

    public $prefix;

    public $internal;

    public $group;

    public function __construct($shell, $name, $prefix = '', $internal = false)
    {
        parent::__construct($shell, $internal);

        $this->name = $name;
        $this->prefix = $prefix.$this->name.'-';
        $this->internal = $internal;
        $this->group = $this->shell->getGroup($this->name);
    }

    public function render()
    {
        /**
         * Return the group view with the group and the prefix.
         */
        return view('beluga::components.group');
    }
}
