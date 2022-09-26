<?php

namespace NoaPe\Beluga\DataTypes\Relations;

class HasMany extends Relation
{
    /**
     * Relation function to call.
     */
    public $relation_function = 'hasMany';

    /**
     * Remove blueprint column.
     */
    public $blueprint_type = false;
}
