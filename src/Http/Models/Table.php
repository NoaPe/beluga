<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends BasicShell
{
    use HasFactory,
        Concerns\HasSubGroups;

    /**
     * The name of the table.
     *
     * @var string
     */
    protected $table = 'beluga_tables';

    /**
     * Name
     */
    public $name;

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
}
