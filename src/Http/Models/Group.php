<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function getRawSchema()
    {
        /**
         * Get the schema from the parent.
         */
        $schema = parent::getRawSchema();

        /**
         * Set groups property with a recursive call and with the group name as key.
         */
        $schema->groups = $this->groups->mapWithKeys(function ($group) {
            return [$group->name => $group->getRawSchema()];
        });

        /**
         * Set datas property with a mapping and data getSchema function with the data name as key.
         */
        $schema->datas = $this->datas->mapWithKeys(function ($data) {
            return [$data->name => $data->getRawSchema()];
        });

    }
}
