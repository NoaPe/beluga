<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\Shell;
use NoaPe\Beluga\Beluga;

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
