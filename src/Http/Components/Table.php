<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\ShellRenderer;

class Table extends ComponentWithShell
{
    public $render_settings;

    public function __construct($shell, $render_settings, $internal = false)
    {
        parent::__construct($shell, $internal);

        $this->shell = $shell;
        $this->render_settings = $render_settings;
    }

    public function render()
    {
        /**
         * Use the ShellRenderer to render the table.
         */
        return ShellRenderer::table($this->shell, $this->render_settings, $this->internal);
    }
}
        