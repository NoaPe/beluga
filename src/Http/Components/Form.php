<?php

namespace NoaPe\Beluga\Http\Components;

class Form extends ComponentWithShell
{
    /**
     * Constructor
     *
     * @param  \NoaPe\Beluga\Shell  $shell
     */
    public function __construct($shell, $internal = false)
    {
        parent::__construct($shell, $internal);
    }

    public function render()
    {
        /**
         * Get the schema from the shell.
         */
        $schema = $this->shell->getSchema();

        /**
         * Return the form view with the schema.
         */
        return view('beluga::components.form', [
            'schema' => $schema,
            'internal' => $this->internal,
        ]);
    }
}
