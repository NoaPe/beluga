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


        $relation = $this->relation_function;
        $class = $settings->class;
        $foreign_key = isset($settings->foreign_key) ? $settings->foreign_key : $this->shell->getForeignKey();
        $where = isset($settings->where) ? $settings->where : null;

        // Add the method to the shell.
        ($this->shell)::resolveRelationUsing($this->name, function ($shell) use ($relation, $class, $foreign_key, $where) {
            $relation = $shell->{$relation}(
                $class,
                $foreign_key
            );

            if ($where) {
                $relation->where(...$where);
            }

            return $relation;
        });
    }
}
