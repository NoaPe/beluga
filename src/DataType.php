<?php

namespace NoaPe\Beluga;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
     * @return mixed|void
     */
    public function addToBlueprint($blueprint)
    {
        if ($this->blueprint_type) {
            $column = $blueprint->{$this->blueprint_type}($this->name);

            if ($this->is('nullable') || ! $this->is('required')) {
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
    }

    /**
     * Function for get the validation rules.
     *
     * @return array
     */
    public function getValidationRules()
    {
        $rules = [];

        if ($this->is('nullable') || ! $this->is('required')) {
            $rules[] = 'nullable';
        }

        if ($this->is('unique')) {
            $rules[] = Rule::unique(($this->shell::class)::getTableName())->ignore($this->shell->id);
        }

        if ($this->is('required')) {
            $rules[] = 'required';
        }

        if ($this->has('validation')) {
            $rules[] = $this->schema->validation;
        }

        if ($this->has('max')) {
            $rules[] = $this->schema->max;
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
        return view('beluga::components.input', [
            'data' => $this->schema,
            'name' => $this->name,
            'input_type' => $this->input_type,
        ]);
    }

    /**
     * Render field.
     */
    public function renderField()
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

    /**
     * Generate seed value.
     *
     * @return mixed
     */
    public function generateSeedValue()
    {
        return Str::random(rand(3, 12));
    }

    /**
     * Generate seed values.
     *
     * @return array
     */
    public function generateSeedValues($number)
    {
        $values = [];

        for ($i = 0; $i < $number; $i++) {
            if ((! $this->is('required')) && mt_rand(0, 2) == 0) {
                $values[] = null;
            } else {
                // Generate the value.
                do {
                    $value = $this->generateSeedValue();
                } while ($this->is('unique') && in_array($value, $values));

                // Add the value to the array.
                $values[] = $value;
            }
        }

        return $values;
    }
}
