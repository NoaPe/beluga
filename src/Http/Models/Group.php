<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends BasicShell
{
    use HasFactory,
        Concerns\HasSubGroups,
        Concerns\IsShowable;

    /**
     * Boolean, true is the parent is group.
     *
     * @var bool
     */
    public $parent_is_group;

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
     * Get validation rules, return an array with the rules without dynamic calling.
     *
     * @return array
     */
    public function getValidationRules()
    {
        return [
            'parent_id' => 'required|integer',
            'parent_is_group' => 'required|boolean',
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'label' => 'nullable|string',
            'description' => 'nullable|string',
            'render' => 'nullable|string',
            'position' => 'nullable|integer',
        ];
    }
}
