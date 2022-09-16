<?php

namespace NoaPe\Beluga;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NoaPe\Beluga\Http\Models\Table;

abstract class Shell extends Model
{
    use Concerns\HasBlueprint,
        Concerns\HasSchema,
        Concerns\HasJsonSchema;

    /**
     * The name of the table.
     *
     * @var string
     */
    protected $table_name;

    /**
     * Table instance.
     */
    protected $table;

    /**
     * Table definition bypass
     */
    protected $table_bypass = false;

    /**
     * Create a new Shell instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [], $migration = false)
    {
        parent::__construct($attributes);

        /**
         * Table name definition
         */
        $this->table_name = get_called_class()::getTableName();

        /**
         * Table instance definition
         * If the table exist in the database, we get it, else test if hasJsonSchema.
         */
        if (! $this->table_bypass && ! $migration && false) {
            $this->table = Table::where('name', $this->table_name)->first();

            if (! $this->table) {
                throw new \Exception('Table '.$this->table_name.' not found in the database please migrate it.');
            }

            $this->table->registerDatas();
        }

        /**
         * Schema definition
         */
        $this->schema = get_called_class()::getJsonSchema();

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
    }

    /**
     * Static function to get table name.
     */
    protected static function getTableName()
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
        $data = $this->getData($key);

        if ($data) {
            $value = $data->set($value);
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
        $data = $this->getData($key);

        if ($data) {
            return $data->get();
        }

        return parent::getAttribute($key);
    }
}
