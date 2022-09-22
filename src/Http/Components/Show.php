<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\ShellRenderer;

class Show extends ComponentWithShell
{
    /**
     * Constructor
     */
    public function __construct($shell, $internal = false)
    {
        parent::__construct($shell, $internal);
    }

    public function render()
    {
        return view('beluga::components.show')->with([
            'shell' => $this->shell,
            'internal' => $this->internal,
        ]);
    }
}
