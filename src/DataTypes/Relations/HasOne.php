<?php

namespace NoaPe\Beluga\DataTypes\Relations;

class HasOne extends Relation
{
    /**
     * Relation function to call.
     */
    public $relation_function = 'hasOne';

    /**
     * Remove blueprint column.
     */
    public $blueprint_type = false;
}
