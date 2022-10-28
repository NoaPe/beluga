<?php

namespace NoaPe\Beluga\DataTypes\Relations;

class ManyToMany extends Relation
{
    /**
     * Relation function to call.
     */
    public $relation_function = 'belongsToMany';

    /**
     * Remove blueprint column.
     */
    public $blueprint_type = false;

    public function register()
    {
        $class = $this->shell->getDataSchema($this->name)->settings->class;
        $relation = $this->relation_function;

        // Add the method to the shell.
        ($this->shell)::resolveRelationUsing($this->name, function ($shell) use ($relation, $class) {
            $relation = $shell->{$relation}(
                $class
            );

            return $relation;
        });
    }
}
