<?php

namespace NoaPe\Beluga\Http\Components;

class Show extends ComponentWithShell
{
    protected $view = 'beluga::components.show';

    /**
     * Constructor
     */
    public function __construct($shell)
    {
        parent::__construct($shell);
    }

    /**
     * Get datas for rendering.
     * 
     * @return array
     */
    public function getDatas()
    {
        return [
            'shell' => $this->shell,
            'internal' => $this->internal,
        ];
    }
}
