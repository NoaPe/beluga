<?php

namespace NoaPe\Beluga\Http\Components;

class Form extends ComponentWithShell
{
    protected $view = 'beluga::components.form';

    /**
     * Method
     *
     * @var string
     */
    protected $method;

    /**
     * Constructor
     *
     * @param  mixed  $shell
     * @param  string  $method
     */
    public function __construct($shell, $method = 'POST')
    {
        parent::__construct($shell);

        $this->method = $method;
    }

    /**
     * Get base datas for rendering.
     *
     * @return array
     */
    public function getDatas()
    {
        // Define datas for rendering
        $schema = $this->shell->getSchema();

        return [
            'schema' => $schema,
            'shell' => $this->shell,
            'internal' => $this->internal,
            'method' => $this->method,
        ];
    }
}
