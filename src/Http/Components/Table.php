<?php

namespace NoaPe\Beluga\Http\Components;

use NoaPe\Beluga\Beluga;

class Table extends ComponentWithShell
{
    use Concerns\HasAddableDatas;

    public $render_settings;

    protected $view = 'beluga::components.table';

    /**
     * Callback function for "where" conditions.
     *
     * @var callable
     */
    protected $where;

    /**
     * Lines to render. If null, all lines will be rendered.
     *
     * @var array
     */
    protected $lines;

    /**
     * Columns to display. If null, all columns will be displayed.
     *
     * @var array
     */
    protected $displayColumns;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $shell
     * @param  mixed  $where
     * @param  mixed  $lines
     * @param  mixed  $displayColumns
     * @param  mixed  $actions
     * @return void
     */
    public function __construct($shell, $where = null, $lines = null, $displayColumns = null, $actions = null)
    {
        parent::__construct($shell);

        $this->where = $where;
        $this->lines = $lines;
        if ($displayColumns) {
            $this->displayColumns = explode(',', $displayColumns);
        }

        if ($actions) {
            $actions = explode(',', $actions);
            foreach ($actions as $key => $action) {
                $actions[$key] = Beluga::qualifyAction($action);
            }
            $this->addDatas(['actions' => $actions]);
        }
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
        } elseif ($this->where == null) {
            $lines = $this->shell::all();
        } else {
            $lines = ($this->where)($this->shell)->get();
        }

        if ($this->displayColumns) {
            $attributes = [];
            foreach ($this->displayColumns as $column) {
                $attributes[$column] = $this->shell->getDataSchema($column);
            }
        } else {
            $attributes = $this->getAttributesFromGroup($schema);
        }

        $datas = [
            'schema' => $schema,
            'lines' => $lines,
            'shell' => $this->shell,
            'data_attributes' => $attributes,
        ];

        return $datas;
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
