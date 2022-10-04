<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\Shell;

abstract class ComponentWithShell extends BasicComponent
{
    public $shell;

    public $internal;

    public function __construct($shell)
    {
        if (is_string($shell)) {
            if ($internal) {
                $shell = config('beluga.internal_shell_namespace').'\\'.$shell;
            } else {
                $shell = config('beluga.shell_namespace').'\\'.$shell;
            }

            $this->shell = new $shell();
        } elseif ($shell instanceof Shell) {
            $this->shell = $shell;
        } else {
            throw new \Exception('Invalid shell provided to component.');
        }

        $this->internal = $shell->isInternal();
    }
}
