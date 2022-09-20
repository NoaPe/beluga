<?php

namespace NoaPe\Beluga\Http\Components;

use Illuminate\View\Component;

class Import extends Component
{
    /**
     * If geo imports is needed.
     *
     * @var bool
     */
    public $geo;

    public function __construct($geo = false)
    {
        $this->geo = $geo;
    }

    public function render()
    {
        return view('beluga::components.import', [
            'geo' => $this->geo,
        ]);
    }
}
