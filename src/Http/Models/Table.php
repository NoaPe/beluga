<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends BasicShell
{
    use HasFactory;

    /**
     * Define hasMany relation with Group model only the Group have parent_is_group to false.
     */
    public function groups()
    {
        return $this->hasMany(Group::class, 'parent_id')->where('parent_is_group', false);
    }

    /**
     * Has many relation with Data model only the Data have parent_is_group to false.
     */
    public function datas()
    {
        return $this->hasMany(Data::class, 'parent_id')->where('parent_is_group', false);
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
         * Set groups property with a mapping and group getSchema function
         */
        if (isset($schema->groups) && is_array($schema->groups)) {
            $groups = new Group();

            foreach ($schema->groups as $key => $group) {
                $groups->{$key} = $group::getRawSchema();
            }

            $schema->groups = $groups;
        }


        /**
         * Set datas property with a mapping and data getSchema function
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
