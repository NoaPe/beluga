<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use NoaPe\Beluga\Beluga;

/**
 * Data model.
 *
 * @property bool $parent_is_group
 * @property string $name
 * @property string $type
 */
class Data extends BasicShell
{
    use HasFactory;

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
     * Function for get data type
     *
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return \NoaPe\Beluga\DataType
     */
    public function getType($shell)
    {
        $class = Beluga::getDataType($this->type);

        return new $class($this->name, $shell);
    }

    /**
     * Register function who call the register function of the data type.
     */
    public function register($shell)
    {
        $this->getType($shell)->register();
    }

    public static function getTableName()
    {
        return 'beluga_datas';
    }

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function getRules($shell)
    {
        return $this->getType($shell)->getValidationRules();
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
