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
