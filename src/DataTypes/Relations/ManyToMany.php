<?php

namespace NoaPe\Beluga\DataTypes\Relations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
    
    protected function getRelationInstance()
    {
        $class = $this->shell->getDataSchema($this->name)->settings->class;

        $relation = $this->shell->{$this->relation_function}(
            $class,
        );

        return $relation;
    }

}
