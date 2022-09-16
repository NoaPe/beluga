<?php

namespace NoaPe\Beluga;

use Illuminate\Database\Schema\Blueprint;

abstract class DataType
{
    /**
     * Name of the data.
     */
    public $name;

    /**
     * Shell
     *
     * @var \NoaPe\Beluga\Shell
     */
    public $shell;

    /**
     * Schema information.
     */
    public $schema;

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
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return void
     */
    public function __construct($name, $shell)
    {
        // Set the name. Throw an exception if the name is not set.
        $this->name = $name;
        $this->shell = $shell;

        $this->schema = $shell->getDataSchema($name);
    }

    /**
     * Static function for get the type name.
     */
    public static function getTypeName()
    {
        return class_basename(get_called_class());
    }
    
    /**
     * is function.
     * 
     * @param  string  $property
     */
    public function is($property)
    {
        return isset($this->schema->$property) && $this->schema->$property;
    }

    /**
     * has function.
     */
    public function has($property)
    {
        return isset($this->schema->$property);
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

        if ($this->is('nullable')) {
            $column->nullable();
        }

        if ($this->is('unique')) {
            $column->unique();
        }

        if ($this->has('default')) {
            $column->default($this->schema->default);
        }

        if ($this->has('length')) {
            $column->length($this->schema->length);
        }

        return $column;
    }

    /**
     * Function for get the validation rules.
     */
    public function getValidationRules()
    {
        $rules = '';

        if ($this->is('nullable')) {
            $rules = 'nullable';
        }

        if ($this->is('unique')) {
            $rules .= '|unique:'.get_called_class()::getTableName();
        }

        if ($this->is('required')) {
            $rules .= '|required';
        }

        if ($this->has('validation')) {
            $rules .= '|'.$this->schema->validation;
        }

        if ($this->has('max')) {
            $rules .= '|max:'.$this->schema->max;
        }

        return $rules;
    }

    /**
     * Set function.
     */
    public function set($value)
    {
        return $this->shell->setAttribute($this->name, $value);
    }

    /**
     * Get function.
     */
    public function get()
    {
        return $this->shell->getAttribute($this->name);
    }

    /**
     * Render input.
     */
    public function renderInput()
    {
        return view('beluga::components.inputs.'.$this->input_type, [
            'data' => $this->schema,
            'name' => $this->name,
        ]);
    }

    /**
     * Public function register.
     */
    public function register()
    {
        //
    }
}
