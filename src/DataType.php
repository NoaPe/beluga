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
     * Html input type.
     */
    public $input_type = 'text';

    /**
     * Constructor
     *
     * @param  string  $name
     * @param  \stdClass  $data
     * @return void
     */
    public function __construct($name, $data)
    {
        // Set the name. Throw an exception if the name is not set.
        $this->name = $name;

        // If is set label, set it.
        if (isset($data->label)) {
            $this->label = $data->label;
        }

        // If is set description, set it.
        if (isset($data->description)) {
            $this->description = $data->description;
        }

        // If is set position, set it.
        if (isset($data->position)) {
            $this->position = $data->position;
        }

        // If is set required, set it.
        if (isset($data->required)) {
            $this->required = $data->required;
        }

        // If is set default, set it.
        if (isset($data->default)) {
            $this->default = $data->default;
        }

        // If is set unique, set it.
        if (isset($data->unique)) {
            $this->unique = $data->unique;
        }

        // If is set nullable, set it.
        if (isset($data->nullable)) {
            $this->nullable = $data->nullable;
        }

        // If is set settings, set it.
        if (isset($data->settings)) {
            $this->settings = $data->settings;
        }

        // If is set validation, set it.
        if (isset($data->validation)) {
            $this->validation = $data->validation;
        }

        // If is set dimension, set it.
        if (isset($data->dimension)) {
            $this->dimension = $data->dimension;
        }

        // If is set max, set it.
        if (isset($data->max)) {
            $this->max = $data->max;
        }
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
     *
     * @param  Blueprint  $blueprint
     * @return mixed
     */
    public function addToBlueprint($blueprint)
    {
        $column = $blueprint->{$this->blueprint_type}($this->name);

        if ($this->nullable) {
            $column->nullable();
        }

        if ($this->unique) {
            $column->unique();
        }

        if (isset($this->default)) {
            $column->default($this->default);
        }

        if (isset($this->length)) {
            $column->length($this->length);
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

        if (isset($this->max)) {
            $rules .= '|max:'.$this->max;
        }

        return $rules;
    }

    /**
     * Set function.
     */
    public function set($value)
    {
        return $value;
    }

    /**
     * Get function.
     */
    public function get($value)
    {
        return $value;
    }

    /**
     * Render input.
     */
    public function renderInput()
    {
        return view('beluga::components.inputs.'.$this->input_type, [
            'data' => $this,
        ]);
    }

    /**
     * Public function register.
     */
    public function register($shell)
    {
        //
    }
}
