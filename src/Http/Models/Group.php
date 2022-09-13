<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use NoaPe\Beluga\Beluga;

class Group extends BasicShell
{
    use HasFactory;

    /**
     * Define hasMany relation with Group model only the Group have parent_is_group to true.
     */
    public function groups()
    {
        return $this->hasMany(Group::class, 'parent_id')->where('parent_is_group', true);
    }

    /**
     * Belongs to relation Group model if parent_is_group is true, Table model if parent_is_group is false.
     */
    public function parent()
    {
        return $this->belongsTo(
            $this->parent_is_group ? Group::class : Table::class,
            'parent_id'
        );
    }

    /**
     * Has many relation with Data model only the Data have parent_is_group to true.
     */
    public function datas()
    {
        return $this->hasMany(Data::class, 'parent_id')->where('parent_is_group', true);
    }

    /**
     * Function who return the stdClass object of the schema.
     */
    public static function getRawSchema()
    {
        /**
         * Get the schema from the parent.
         */
        $schema = parent::getRawSchema();

        /**
         * Set groups property with a recursive call and use $group->name as $key.
         */
        if (isset($schema->groups) && is_array($schema->groups)) {
            $groups = new Group();

            foreach ($schema->groups as $key => $group) {
                $groups->{$key} = $group::getRawSchema();
            }

            $schema->groups = $groups;
        }

        /**
         * Set datas property with a mapping and data getSchema function with the data name as key.
         */
        if (isset($schema->datas) && is_array($schema->datas)) {
            $datas = new \stdClass();

            foreach ($schema->datas as $key => $data) {
                $class = Beluga::getDataType($data->type);
                $datas->{$key} = $class;
            }

            $schema->datas = $datas;
        }

        return $schema;
    }
}
