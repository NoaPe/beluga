<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Http\Models\Data;
use NoaPe\Beluga\Http\Models\Group;

trait HasSchema
{
    /**
     * Schema information array.
     *
     * @var mixed
     */
    protected $schema;

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
     * Function for get a data type from exploration of the schema.
     *
     * @param  string  $name
     * @param  mixed  $group
     * @return mixed DataType or null
     */
    public function getDataType($name, $group = null)
    {
        if ($group == null) {
            $group = $this->schema;
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
     * Filter datas from boolean callback.
     */
    protected function filterDatas($callback)
    {
        return $this->filterDatasInGroup($this->schema, $callback);
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
     * Getter schema.
     *
     * @return \NoaPe\Beluga\Http\Models\Table
     */
    public function getSchema()
    {
        if ($this->schema) {
            return $this->schema;
        }

        if (method_exists($this, 'getSchemaFrom'.$this->schema_origin)) {
            $this->schema = $this->{'getSchemaFrom'.$this->schema_origin}();

            return $this->schema;
        } else {
            throw new \Exception('Schema origin "'.$this->schema_origin.'" not found.');
        }
    }

    /**
     * Get a data raw schema from a key.
     *
     * @param  string  $key
     */
    public function getDataSchema($key)
    {
        return self::getDataSchemaFromGroup($key, $this->schema);
    }

    /**
     * Get a data raw schema from a key.
     */
    public static function getDataSchemaFromGroup($key, $group)
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
        return $this->getGroupFromGroup($name, $this->schema);
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
