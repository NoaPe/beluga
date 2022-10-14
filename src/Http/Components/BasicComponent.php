<?php

namespace NoaPe\Beluga\Http\Components;

use Illuminate\View\Component;

class BasicComponent extends Component
{
    /**
     * View.
     *
     * @var string
     */
    protected $view;

    /**
     * Get datas to send to the view.
     *
     * @return array
     */
    public function getDatas()
    {
        return [];
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view($this->view, $this->getDatas());
    }
}
