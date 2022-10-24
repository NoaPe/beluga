<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Table extends BasicShell
{
    use HasFactory,
        Concerns\HasSubGroups,
        Concerns\IsShowable;

    /**
     * Name
     */
    public $name;

    /**
     * Has many relation with Data model only the Data have parent_is_group to false.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datas()
    {
        return $this->hasMany(Data::class, 'parent_id')->where('parent_is_group', false);
    }

    /**
     * Get validation rules, return an array with the rules without dynamic calling.
     *
     * @return array
     */
    public function getValidationRules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(($this::class)::getTableName())->ignore($this->id),
            ],
            'description' => 'nullable|string',
            'render' => 'nullable|string',
        ];
    }
}
