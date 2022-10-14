<?php

namespace NoaPe\Beluga\Http\Components;

class Group extends ComponentWithShell
{
    public $name;

    public $prefix;

    public $group;

    protected $view = 'beluga::components.group';

    public function __construct($shell, $name, $prefix = '')
    {
        parent::__construct($shell);

        $this->name = $name;
        $this->prefix = $prefix.$this->name.'-';
        $this->group = $this->shell->getGroup($this->name);
    }
}
