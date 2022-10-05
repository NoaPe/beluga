<?php

namespace NoaPe\Beluga\Http\Components;

class Table extends ComponentWithShell
{
    use Concerns\HasAddableDatas;

    public $render_settings;

    protected $view = 'beluga::components.table';

    protected $group;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $shell
     * @param  mixed  $group
     * @return void
     */
    public function __construct($shell, $group = null)
    {
        parent::__construct($shell);

        $this->group = $group;
    }

    /**
     * Define base datas for rendering.
     *
     * @return array
     */
    public function baseDatas()
    {
        // Is the group is set send it else get the schema from the shell.
        if ($this->group) {
            $schema = $this->group;
        } else {
            $schema = $this->shell->getSchema();
        }
        // Get all lines from the shell.
        $lines = $this->shell::all();

        return [
            'schema' => $schema,
            'lines' => $lines,
            'shell' => $this->shell,
        ];
    }
}
