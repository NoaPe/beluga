<?php

namespace NoaPe\Beluga\DataTypes\Relations;

use NoaPe\Beluga\Beluga;
use NoaPe\Beluga\DataType;

class Relation extends DataType
{
    /**
     * Blueprint type.
     */
    public $blueprint_type = 'string';

    /**
     * Relation function to call.
     */
    public $relation_function = 'hasOne';

    /**
     * Register function who add the relation to the shell.
     */
    public function register()
    {
        // Get the shell class name.
        $class = Beluga::qualifyShell($this->shell);

        $relation = $this->shell->{$this->relation_function}(
            $this->schema->settings->class,
        );

        // Add the method to the shell.
        $this->shell->{$this->name} = function () use ($relation) {
            return $relation;
        };
    }
}
