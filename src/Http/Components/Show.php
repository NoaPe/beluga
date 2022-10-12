<?php

namespace NoaPe\Beluga\Http\Components;

class Show extends ComponentWithShell
{
    use Concerns\HasAddableDatas;

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
    public function baseDatas()
    {
        return [
            'shell' => $this->shell,
            'schema' => $this->shell->getSchema(),
            'internal' => $this->internal,
        ];
    }
}
