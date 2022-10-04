<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\Beluga;
use NoaPe\Beluga\Shell;

abstract class ComponentWithShell extends BasicComponent
{
    public $shell;

    public $internal;

    public function __construct($shell)
    {
        if (is_string($shell)) {
            $shell = Beluga::qualifyShell($shell);
            $this->shell = new $shell();
        } elseif ($shell instanceof Shell) {
            $this->shell = $shell;
        } else {
            throw new \Exception('Invalid shell provided to component.');
        }

        $this->internal = $shell->isInternal();
    }
}
