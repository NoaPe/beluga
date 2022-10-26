<?php

namespace NoaPe\Beluga\Http\Components;

class Table extends ComponentWithShell
{
    use Concerns\HasAddableDatas;

    public $render_settings;

    protected $view = 'beluga::components.table';

    protected $group;

    /**
     * Callback function for "where" conditions.
     *
     * @var callable
     */
    protected $where;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $shell
     * @param  mixed  $where
     * @param  mixed  $lines
     * @return void
     */
    public function __construct($shell, $where = null, $lines = null)
    {
        parent::__construct($shell);

        $this->where = $where;
        $this->lines = $lines;
    }

    /**
     * Define base datas for rendering.
     *
     * @return array
     */
    public function baseDatas()
    {
        $schema = $this->shell->getSchema();

        // Get all lines from the shell.
        if ($this->lines) {
            $lines = $this->lines;
        }else if ($this->where == null) {
            $lines = $this->shell::all();
        } else {
            $lines = ($this->where)($this->shell)->get();
        }

        $attributes = $this->getAttributesFromGroup($schema);

        return [
            'schema' => $schema,
            'lines' => $lines,
            'shell' => $this->shell,
            'data_attributes' => $attributes,
        ];
    }

    /**
     * Get attributes from group.
     *
     * @param  mixed  $group
     * @return array
     */
    protected function getAttributesFromGroup($group)
    {
        $attributes = [];

        if (isset($group->datas)) {
            $attributes = (array) $group->datas;
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $subgroup) {
                $attributes = array_merge($attributes, $this->getAttributesFromGroup($subgroup));
            }
        }

        return $attributes;
    }
}
