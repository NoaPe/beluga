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
