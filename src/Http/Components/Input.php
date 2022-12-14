<?php

namespace NoaPe\Beluga\Http\Components;

class Input extends ComponentWithShell
{
    public $prefix;

    public $name;

    public function __construct($shell, $prefix, $name)
    {
        parent::__construct($shell);

        $this->prefix = $prefix;
        $this->name = $name;
    }

    protected function getData()
    {
        $schema = $this->shell->getSchema();

        if ($this->prefix) {
            $parent = $schema;

            /**
             * We explode the prefix with "-" and we take successive sub groups of the schema.
             */
            $groupsName = explode('-', $this->prefix);

            foreach ($groupsName as $groupName) {
                if ($groupName !== '') {
                    $parent = $parent->groups->$groupName;
                }
            }

            $data = $parent->datas->{$this->name};
        } else {
            $data = $schema->datas->{$this->name};
        }

        return $data;
    }

    public function render()
    {
        $data = $this->getData();

        // Return the view from the data type
        return $data->getType($this->shell)->renderInput();
    }
}
