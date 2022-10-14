<?php

namespace NoaPe\Beluga\Http\Components;

class Import extends BasicComponent
{
    /**
     * If geo imports is needed.
     *
     * @var bool
     */
    public $geo;

    protected $view = 'beluga::components.import';

    public function __construct($geo = false)
    {
        $this->geo = $geo;
    }

    /**
     * Get datas for rendering.
     *
     * @return array
     */
    public function getDatas()
    {
        return [
            'geo' => $this->geo,
        ];
    }
}
