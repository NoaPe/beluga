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
}
