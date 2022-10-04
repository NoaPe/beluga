<?php

namespace NoaPe\Beluga\Http\Components;

class Table extends ComponentWithShell
{
    use Concerns\HasAddableDatas;

    public $render_settings;

    protected $view = 'beluga::components.table';

    /**
     * Define base datas for rendering.
     *
     * @return array
     */
    public function baseDatas()
    {
        // Get the schema from the shell.
        $schema = $this->shell->getSchema();

        // Get all lines from the shell.
        $lines = $this->shell::all();

        return [
            'schema' => $schema,
            'lines' => $lines,
            'internal' => $this->internal,
        ];
    }
}
