<?php

namespace NoaPe\Beluga\DataTypes\Relations;

class BelongsTo extends Relation
{
    /**
     * Relation function to call.
     */
    public $relation_function = 'belongsTo';

    /**
     * Html input type.
     */
    public $input_type = 'select';

    /**
     * Options
     */
    public $options = [];

    /**
     * Constructor
     *
     * @param  \NoaPe\Beluga\Shell  $shell
     * @param  string  $name
     * @return void
     */
    public function __construct($shell, $name)
    {
        parent::__construct($shell, $name);

        $options = [];

        $class = new $this->schema->settings->class();

        foreach ($class::all() as $item) {
            $options[(string) $item->id] = $item->toString();
        }

        $this->options = $options;
    }

    /**
     * Render input.
     */
    public function renderInput()
    {
        return view('beluga::components.input', [
            'data' => $this->schema,
            'name' => $this->name,
            'options' => $this->options,
            'input_type' => $this->input_type,
        ]);
    }

    /**
     * Generate seed value.
     *
     * @return string
     */
    public function generateSeedValue()
    {
        $options = array_keys((array) $this->options);

        return $options[rand(0, count($options) - 1)];
    }
}
