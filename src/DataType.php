<?php

namespace NoaPe\Beluga;

use Illuminate\Database\Schema\Blueprint;

abstract class DataType
{
    /**
     * The name of the data.
     */
    public $name;

    /**
     * The table name.
     */
    public $table_name;

    /**
     * The label of the data
     */
    public $label;

    /**
     * The description.
     */
    public $description;

    /**
     * The position.
     */
    public $position;

    /**
     * If the value is required.
     */
    public $required = false;

    /**
     * The default value.
     */
    public $default;

    /**
     * If unique.
     */
    public $unique = false;

    /**
     * If nullable.
     */
    public $nullable = true;

    /**
     * Settings array.
     */
    public $settings;

    /**
     * Validation rules.
     */
    public $validation;

    /**
     * The dimension.
     */
    public $dimension;

    /**
     * Maximum length.
     */
    public $max;

    /**
     * Blueprint type.
     */
    public $blueprint_type = 'string';

    /**
     * Constructor
     */
    public function __construct($data)
    {
        $this->name = $data->name;
        $this->table_name = $data->table_name;
        $this->label = $data->label;
        $this->description = $data->description;
        $this->position = $data->position;
        $this->required = $data->required;
        $this->default = $data->default;
        $this->unique = $data->unique;
        $this->nullable = $data->nullable;
        $this->settings = $data->settings;
        $this->validation = $data->validation;
        $this->dimension = $data->dimension;
        $this->max = $data->max;
    }

    /**
     * Static function for get the type name.
     */
    public static function getTypeName()
    {
        return class_basename(get_called_class());
    }

    /**
     * Function for add the column to the blueprint schema.
     */
    public function addToBlueprint(Blueprint $blueprint)
    {
        $column = $blueprint->{$this->blueprint_type}($this->name);

        if ($data->nullable) {
            $column->nullable();
        }

        if ($data->unique) {
            $column->unique();
        }

        if (isset($data->default)) {
            $column->default($data->default);
        }

        if (isset($data->length)) {
            $column->length($data->length);
        }

        return $column;
    }

    /**
     * Function for get the validation rules.
     */
    public function getValidationRules()
    {
        
        $rules = '';

        if ($this->nullable) {
            $rules = 'nullable';
        }

        if ($this->unique) {
            $rules .= '|unique:'.get_called_class()::getTableName();
        }

        if ($this->required) {
            $rules .= '|required';
        }

        if (isset($this->validation)) {
            $rules .= '|'.$this->validation;
        }

        /**
         * If the max is set, add the max rule.
         */
        if (isset($this->max)) {
            $rules[$nameD] .= '|max:'.$this->max;
        }

        return $rules;
    }

}