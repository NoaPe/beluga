<?php

namespace NoaPe\Beluga;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NoaPe\Beluga\Http\Models\Table;

class Shell extends Model
{
    use Concerns\HasBlueprint,
        Concerns\HasSchema,
        Concerns\HasJsonSchema,
        Concerns\HasInternalJsonSchema,
        Concerns\HasDatabaseSchema;

    /**
     * The name of the table.
     *
     * @var string
     */
    protected $table;

    /**
     * Table definition bypass
     */
    protected $table_bypass = false;

    /**
     * Schema origin
     *
     * @var string
     */
    protected $schema_origin = 'Json';

    /**
     * Route prefix
     *
     * @var string
     */
    protected $route = '';

    /**
     * Create a new Shell instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        /**
         * Table name definition
         */
        $this->table = static::getTableName();

        $this->schema = $this->getSchema();

        if ($this->schema instanceof Table) {
            $this->schema->registerDatas($this);
        }

        /**
         * Set fillable attributes
         */
        $this->fillable = $this->getFillables();

        /**
         * Set guarded attributes
         */
        $this->guarded = $this->getGuardeds();

        /**
         * Set hidden attributes
         */
        $this->hidden = $this->getHiddens();

        if ($this->route == '') {
            $this->route = $this->table;
        }

        parent::__construct($attributes);
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Return class name.
     *
     * @return string
     */
    public function getName()
    {
        return class_basename(get_called_class());
    }

    /**
     * Static function to get table name.
     *
     * @return string
     */
    public static function getTableName()
    {
        return Str::snake(Str::pluralStudly(class_basename(get_called_class())));
    }

    /**
     * Function who use set function of appropriate data type and set attrbute
     *
     * @param  string  $key
     * @param  string  $value
     */
    public function setAttribute($key, $value)
    {
        $data = $this->getDataType($key);

        if ($data) {
            $value = (new $data($key, $this))->set($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Function who use get function of appropriate data type and return attribute.
     *
     * @param  string  $key
     */
    public function getAttribute($key)
    {
        $data = $this->getDataType($key);

        $value = parent::getAttribute($key);

        if ($data) {
            $value = (new $data($key, $this))->get($value);
        }

        return $value;
    }

    /**
     * To string function.
     *
     * @return string
     */
    public function toString()
    {
        return $this->getAttribute('name');
    }
}
