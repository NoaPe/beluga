<?php

namespace NoaPe\Beluga\Http\Components;

class Input extends ComponentWithShell
{
    public $prefix;

    public $name;

    public function __construct($shell, $prefix, $name, $internal = false)
    {
        parent::__construct($shell, $internal);

        $this->prefix = $prefix;
        $this->name = $name;
    }

    public function render()
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

        // Return the view from the data type
        return $data->getType($this->shell)->renderInput();
    }
}
