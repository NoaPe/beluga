<?php

namespace NoaPe\Beluga\Http\Components;

class SelectGroup extends BasicComponent
{
    public $group;

    protected $view = 'beluga::components.inputs.select-group';

    /**
     * Constructor
     */
    public function __construct($group)
    {
        $this->group = $group;
    }

    /**
     * Get datas for rendering.
     *
     * @return array
     */
    public function getDatas()
    {
        return [
            'group' => $this->group,
        ];
    }
}
