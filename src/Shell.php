<?php

namespace NoaPe\Beluga;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

abstract class Shell extends Model
{
    /**
     * Schema information array.
     *
     * @var array
     */
    protected $schema = [];

    /**
     * The name of the table.
     *
     * @var string
     */
    protected $table_name;

    /**
     * Create a new Shell instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        /**
         * Table name definition
         */
        $this->table_name = Str::snake(Str::pluralStudly(class_basename($this)));

        /**
         * Get schema information from Json file.
         */
        $file = config('beluga.schema_path').'/'.class_basename($this).'Schema.json';
        if (! file_exists($file)) {
            $data = file_get_contents($file);
        } else {
            // Define by database table
        }

        
        $this->schema = json_decode($data);

        /**
         * Set default values
         */
        $this->addDefaultProperties();

        dd($this->schema);
    }

    public function checkStructure()
    {
        //dd(config('beluga.schema_path'));
        //dd(Schema::getColumnListing($this->getTable()));
        //Schema::getColumnType($table,$column)
    }

    /**
     * Add default value on a table from a list of default value in the $config_name.
     *
     * @param  array  $table
     * @param  string  $config_name
     * @return void
     */
    protected function addDefaultTableProperties($table, $config_name)
    {
        $default_properties = config('beluga.'.$config_name);

        foreach ($default_properties as $name => $value) {
            if (! isset($table[$name])) {
                $table[$name] = $value;
            }
        }

        return $table;
    }

    /**
     * Recursive function on groups for add default properties to data table.
     *
     * @param  array  $groups
     * @return array
     */
    protected function addDefaultPropertiesInGroups($groups)
    {
        foreach ($groups as $name => $group) {
            /**
             * If the group have sub-groups we do a recursive call of the function.
             */
            if (isset($group['groups'])) {
                $groups[$name]['groups'] = $this->addDefaultPropertiesInGroups($group['groups']);
            }

            /**
             * If the groups have data definitions, we set the default values for each one.
             */
            if (isset($group['datas'])) {
                foreach ($group['datas'] as $nameD => $data) {
                    $groups[$name]['datas'][$nameD] = $this->addDefaultTableProperties($data, 'default_data_properties');
                }
            }
        }

        return $groups;
    }

    /**
     * Add default properties to a schema.
     *
     * @return void
     */
    protected function addDefaultProperties()
    {
        $table = $this->addDefaultTableProperties($this->table, 'default_schema_properties');

        $table['groups'] = $this->addDefaultPropertiesInGroups($table['groups']);

        $this->table = $table;
    }

    /**
     * Add fields to $blueprint from a $groupe, recursive on sub-groups.
     *
     * @param  array  $group
     * @param  Blueprint  $blueprint
     * @return void
     */
    protected function addGroupToBlueprint($group, $blueprint)
    {
        foreach ($group['datas'] as $name => $data) {
            if (is_callable($this, $data['type'])) {
                $column = $this->{$data['type']}($name);

                if ($data['nullable']) {
                    $column->nullable();
                }

                if ($data['unique']) {
                    $column->unique();
                }

                if (isset($data['default'])) {
                    $column->default($data['default']);
                }
            }
        }

        if (isset($group['groups'])) {
            foreach ($group['groups'] as $group2) {
                $this->addGroupToBlueprint($group2, $blueprint);
            }
        }
    }

    /**
     * Create database table of the model.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $blueprint) {
            if ($this->schema['id']) {
                $blueprint->id();
            }

            if ($this->schema['timestamps']) {
                $blueprint->timestamps();
            }

            foreach ($this->schema['groups'] as $name => $group) {
                $this->addGroupToBlueprint($group, $blueprint);
            }
        });
    }

    /**
     * Cancel a creation of table in the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table_name);
    }
}
