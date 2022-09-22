<?php

namespace NoaPe\Beluga\Http\Models\Concerns;

use NoaPe\Beluga\Beluga;

trait HasSubGroups
{
    /**
     * Subgroups
     */
    public $groups;

    /**
     * Datas
     */
    public $datas;

    /**
     * Call register function of each datas of the table.
     *
     * @return void
     */
    public function registerDatas($shell)
    {
        // Call register function of each data in $this->datas
        if (isset($this->datas) && is_array($this->datas)) {
            foreach ($this->datas as $key => $data) {
                $data->register($shell);
            }
        }

        if (isset($this->groups)) {
            // Call register function of each group in $this->groups
            foreach ($this->groups as $group) {
                $group->registerDatas($shell);
            }
        }
    }

    /**
     * Get validation rules.
     * 
     * @return array
     */
    public function getRules($shell)
    {
        $rules = [];

        // Get the validation rules of each data
        if (isset($this->datas)) {
            foreach ($this->datas as $key => $data) {
                $rules[$key] = $data->getRules($shell);
            }
        }

        // Get the validation rules of each group
        if (isset($this->groups)) {
            foreach ($this->groups as $group) {
                $rules = array_merge($rules, $group->getRules($shell));
            }
        }

        return $rules;
    }
}
