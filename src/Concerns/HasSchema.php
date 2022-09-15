<?php

namespace NoaPe\Beluga\Concerns;

use NoaPe\Beluga\Beluga;
use NoaPe\Beluga\Http\Models\Data;
use NoaPe\Beluga\Http\Models\Group;

trait HasSchema
{
    /**
     * Schema information array.
     *
     * @var array
     */
    protected $schema;

    /**
     * Static function to get a validation rules in array format.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        $rules = [];

        $schema = get_called_class()::getJsonSchema();

        // TO DO

        return $rules;
    }

    /**
     * Function for get a data type from exploration of the schema.
     *
     * @param  string  $key
     * @param  mixed  $group
     * @return mixed Data type or null
     */
    public function getDataType($key, $group = null)
    {
        if ($group == null) {
            $group = $this->schema;
        }

        if (isset($group->datas)) {
            foreach ($group->datas as $data) {
                if ($data->name == $key) {
                    return $data;
                }
            }
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                $data = $this->getDataType($key, $group2);

                if ($data !== null) {
                    return $data;
                }
            }
        }

        return null;
    }

    /**
     * Recursive static function for get the schema of group with instanciate data types.
     *
     * @param  mixed  $group
     * @return mixed
     */
    protected static function getGroupSchema($group)
    {
        /**
         * If groups is set, replace each sub group with call to this function.
         */
        if (isset($group->groups)) {
            foreach ($group->groups as $key => $value) {
                $group->groups->{$key} = get_called_class()::getGroupSchema($value);
            }
        }

        /**
         * If data is set, replace each data with instanciate data type.
         */
        if (isset($group->datas)) {
            foreach ($group->datas as $key => $data) {
                $class = Beluga::getDataType($data->type);
                $group->datas->{$key} = new $class($key, $data);
            }
        }

        return $group;
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

        foreach ($group->datas as $data) {
            if ($callback($data)) {
                $datas[] = $data;
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
            return $data->fillable;
        });
    }

    /**
     * Get hidden attributes from schema.
     */
    public function getHiddens()
    {
        return $this->filterDatas(function ($data) {
            return $data->hidden;
        });
    }

    /**
     * Get guarded attributes from schema.
     */
    public function getGuardeds()
    {
        return $this->filterDatas(function ($data) {
            return $data->guarded;
        });
    }
}
