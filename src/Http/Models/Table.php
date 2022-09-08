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
    public function getSchema()
    {  
        /**
         * Get the schema from the parent.
         */
        $schema = parent::getSchema();

        /**
         * Set groups property with a mapping and group getSchema function
         */
        $schema->groups = $this->groups->map(function ($group) {
            return $group->getSchema();
        });

        /**
         * Set datas property with a mapping and data getSchema function
         */
        $schema->datas = $this->datas->map(function ($data) {
            return $data->getSchema();
        });
    }

}
