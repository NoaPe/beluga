<?php

namespace NoaPe\Beluga\Http\Components;

class Form extends ComponentWithShell
{
    use Concerns\HasAddableDatas;

    protected $view = 'beluga::components.form';

    /**
     * Get base datas for rendering.
     *
     * @return array
     */
    public function baseDatas()
    {
        // Define datas for rendering
        $schema = $this->shell->getSchema();

        return [
            'schema' => $schema,
            'shell' => $this->shell,
            'internal' => $this->internal,
        ];
    }
}
