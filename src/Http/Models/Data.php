<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use NoaPe\Beluga\Beluga;

/**
 * Data model.
 * 
 * @property boolean $parent_is_group
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
     * @param \NoaPe\Beluga\Shell $shell
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
}
