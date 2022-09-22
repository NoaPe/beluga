<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\ShellRenderer;

class Table extends ComponentWithShell
{
    public $render_settings;

    public function __construct($shell, $render_settings = [], $internal = false)
    {
        parent::__construct($shell, $internal);

        $this->render_settings = $render_settings;
    }

    public function render()
    {
        /**
         * Get the schema from the shell.
         */
        $schema = $this->shell->getSchema();

        /**
         * Get all lines from the shell.
         */
        $lines = $this->shell::all();

        /**
         * Return the table view with the schema and the lines.
         */
        return view('beluga::components.table', [
            'schema' => $schema,
            'lines' => $lines,
            'render_settings' => $this->render_settings,
            'internal' => $this->internal,
        ]);
    }
}
