<?php

namespace NoaPe\Beluga\Http\Components;

use Illuminate\View\Component;

class SelectGroup extends Component
{

    public $group;

    /**
     * Constructor
     */
    public function __construct($group)
    {
        $this->group = $group;
    }

    public function render()
    {
        return view('beluga::components.inputs.select-group', [
            'group' => $this->group,
        ]);
    }
}
