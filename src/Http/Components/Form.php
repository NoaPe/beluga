<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\ShellRenderer;

class Form extends ComponentWithShell
{
    public function render()
    {
        /**
         * Use the ShellRenderer to render the form.
         */
        return ShellRenderer::form($this->shell, $this->internal);
    }
}
