<?php

namespace NoaPe\Beluga;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use NoaPe\Beluga\Http\Models\Table;

class Shell extends Model
{
    use Concerns\HasBlueprint,
        Concerns\HasSeeding,
        Auth\HasOwningRelation;

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
     * Schema folder
     * 
     * @var string
     */
    protected $schema_folder = '';

    /**
     * Route prefix
     *
     * @var string
     */
    protected $route = '';

    /**
     * Is internal
     *
     * @var bool
     */
    protected $internal = false;

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

        if ($this->getSchema() instanceof Table) {
            $this->getSchema()->registerDatas($this);
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
     * Get foreignkey name.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return Str::snake(class_basename(get_called_class())).'_id';
    }

    /**
     * Get element name
     *
     * @return string
     */
    public static function getElementName()
    {
        return Str::snake(class_basename(static::class));
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
     * Function for get a data type from exploration of the schema.
     *
     * @param  string  $name
     * @param  mixed  $group
     * @return mixed DataType or null
     */
    public function getDataType($name, $group = null)
    {
        if ($group == null) {
            $group = $this->getSchema();
        }

        if (isset($group->datas)) {
            foreach ($group->datas as $key => $data) {
                if ($key == $name) {
                    return $data->getType($this);
                }
            }
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                $data = $this->getDataType($name, $group2);

                if ($data !== null) {
                    return $data;
                }
            }
        }

        return null;
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

    /**
     * Is internal function.
     *
     * @return bool
     */
    public function isInternal()
    {
        return $this->internal;
    }

    /**
     * Get schema
     *
     * @return mixed
     */
    public function getSchema()
    {
        return Anchor::getSchema($this, $this->schema_origin, $this->schema_folder);
    }

    /**
     * Static function to get a validation rules in array format.
     *
     * @return array
     */
    public function getValidationRules()
    {
        $rules = [];

        // Get the schema
        $schema = $this->getSchema();

        return $schema->getRules($this);
    }

    /**
     * Filter datas from boolean callback.
     */
    protected function filterDatas($callback)
    {
        return $this->filterDatasInGroup($this->getSchema(), $callback);
    }

    /**
     * Filter datas in group.
     */
    protected function filterDatasInGroup($group, $callback)
    {
        $datas = [];

        if (isset($group->datas)) {
            foreach ($group->datas as $key => $data) {
                if ($callback($data)) {
                    $datas[] = $key;
                }
            }
        }

        // Recursive call in sub groups
        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                $datas = array_merge($datas, $this->filterDatasInGroup($group2, $callback));
            }
        }

        return $datas;
    }

    /**
     * Get fillable attributes from schema.
     */
    public function getFillables()
    {
        return $this->filterDatas(function ($data) {
            return isset($data->fillable) && $data->fillable;
        });
    }

    /**
     * Get hidden attributes from schema.
     */
    public function getHiddens()
    {
        return $this->filterDatas(function ($data) {
            return isset($data->hidden) && $data->hidden;
        });
    }

    /**
     * Get guarded attributes from schema.
     */
    public function getGuardeds()
    {
        return $this->filterDatas(function ($data) {
            return isset($data->guarded) && $data->guarded;
        });
    }

    /**
     * Get a data raw schema from a key.
     *
     * @param  string  $key
     */
    public function getDataSchema($key)
    {
        return self::getDataSchemaFromGroup($key, $this->getSchema());
    }

    /**
     * Get a data raw schema from a key.
     */
    public function getDataSchemaFromGroup($key, $group)
    {
        if (isset($group->datas)) {
            foreach ($group->datas as $name => $data) {
                if ($name == $key) {
                    return $data;
                }
            }
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                $data = self::getDataSchemaFromGroup($key, $group2);

                if ($data !== null) {
                    return $data;
                }
            }
        }

        return null;
    }

    /**
     * Get a group from a name.
     *
     * @param  string  $name
     * @return mixed
     */
    public function getGroup($name)
    {
        return $this->getGroupFromGroup($name, $this->getSchema());
    }

    /**
     * Get a group from a name.
     *
     * @param  string  $name
     * @param  mixed  $group
     * @return mixed
     */
    protected function getGroupFromGroup($name, $group)
    {
        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                if ($group2->name == $name) {
                    return $group2;
                }
            }
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                $group3 = $this->getGroupFromGroup($name, $group2);

                if ($group3 !== null) {
                    return $group3;
                }
            }
        }

        return null;
    }
}
