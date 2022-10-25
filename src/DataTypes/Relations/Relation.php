<?php

namespace NoaPe\Beluga\DataTypes\Relations;

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
        $settings = $this->shell->getDataSchema($this->name)->settings;

        $relation = $this->shell->{$this->relation_function}(
            $settings->class,
            $settings->foreign_key,
        );

        if (isset($settings->where)) {
            $relation->where(...$settings->where);
        }

        // Add the method to the shell.
        ($this->shell)::resolveRelationUsing($this->name, function ($orderModel) use ($relation) {
            return $relation;
        });
    }
}
