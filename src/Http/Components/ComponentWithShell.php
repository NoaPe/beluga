<?php
namespace NoaPe\Beluga\Http\Components;

use Illuminate\View\Component;
use NoaPe\Beluga\Shell;

abstract class ComponentWithShell extends Component 
{
    public $shell;

    public $internal;

    public function __construct($shell, $internal = false)
    {
        if (is_string($shell)) {
            if ($internal) {
                $shell = config('beluga.internal_shell_namespace').'\\'.$shell;
            } else {
                $shell = config('beluga.shell_namespace').'\\'.$shell;
            }
    
            $this->shell = new $shell();
        } else if ($shell instanceof Shell) {
            $this->shell = $shell;
        } else {
            throw new \Exception('Invalid shell provided to component.');
        }

        $this->internal = $internal;
    }
}