<?php

namespace NoaPe\Beluga\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use NoaPe\Beluga\Beluga;

class Data extends BasicShell
{
    use HasFactory;

    /**
     * Boolean, true is the parent is group.
     *
     * @var bool
     */
    public $parent_is_group;

    /**
     * Data type.
     *
     * @var string
     */
    public $type;

    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Static function for set the table name to "datas" with the config prefix.
     */
    public static function getTableName()
    {
        return config('beluga.table_prefix').'datas';
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
     * Function for get data type
     */
    public function getType()
    {
        return Beluga::getDataType($this->type);
    }

    /**
     * Register function who call the register function of the data type.
     */
    public function register($shell)
    {
        $this->getType()->register($shell);
    }
}
