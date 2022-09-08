<?php

namespace NoaPe\Beluga;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use NoaPe\Beluga\Models\Data;
use NoaPe\Beluga\Models\Group;

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
        $this->table_name = get_called_class()::getTableName();

        /**
         * Schema definition
         */
        $this->schema = get_called_class()::getSchema();

        /**
         * Set default values
         */
        $this->addDefaultProperties();
        
    }

    /**
     * Static function for get a name of schema file.
     */
    public static function getSchemaFileName()
    {
        return config('beluga.schema_path').'/'.class_basename(get_called_class()).'Schema.json';
    }

    /**
     * Static function to get raw schema information.
     */
    protected static function getRawSchema()
    {
        /**
         * Get schema information from Json file.
         */
        $file = get_called_class()::getSchemaFileName();
        $data = new \stdClass();

        if (file_exists($file)) {
            $data = file_get_contents($file);
        } else {

            /**
             * Get the table who has the same name as the shell.
             */
            $table = Table::where('table_name', get_called_class()::getTableName())->get();

            /**
             * If the table exists, get the schema information from the database.
             */
            if ($table->count() > 0) {

                $table = $table->first();

                /**
                 * Get schema form Table model
                 */
                $data = $table->getSchema();

            } else {
                /**
                 * Throw exception if schema file does not exist with the name of the expected file.
                 */
                throw new \Exception('Schema file does not exist: '.$file);
            }
        }

        return json_decode($data);
    }

    /**
     * Static function to get schema information.
     */
    protected static function getSchema()
    {
        return self::addDefaultProperties(get_called_class()::getRawSchema());
    }

    /**
     * Static function to get table name.
     */
    protected static function getTableName()
    {
        return Str::snake(Str::pluralStudly(class_basename(get_called_class())));
    }

    /**
     * Add default value on a table from a list of default value in the $config_name.
     *
     * @param  array  $table
     * @param  string  $config_name
     * @return void
     */
    protected static function addDefaultTableProperties($table, $config_name)
    {
        $default_properties = config('beluga.'.$config_name);

        foreach ($default_properties as $name => $value) {
            if (! isset($table->$name)) {
                $table->$name = $value;
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
    protected static function addDefaultPropertiesInGroups($groups)
    {
        foreach ($groups as $name => $group) {
            /**
             * If the group have sub-groups we do a recursive call of the function.
             */
            if (isset($group->groups)) {
                $groups->$name->groups = self::addDefaultPropertiesInGroups($group->groups);
            }

            /**
             * If the groups have data definitions, we set the default values for each one.
             */
            if (isset($group->datas)) {
                foreach ($group->datas as $nameD => $data) {
                    $groups->$name->datas->$nameD = self::addDefaultTableProperties($data, 'default_data_properties');
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
    protected static function addDefaultProperties($schema)
    {
        $table = self::addDefaultTableProperties($schema, 'default_schema_properties');

        if (isset($table->groups)) {
            $table->groups = self::addDefaultPropertiesInGroups($table->groups);
        }

        if (isset($table->datas)) {
            foreach ($table->datas as $name => $data) {
                $table->datas->$name = self::addDefaultTableProperties($data, 'default_data_properties');
            }
        }

        return $schema;
    }

    /**
     * Add fields to $blueprint from $datas table.
     * 
     * @param array $datas
     * @param  Blueprint  $blueprint
     * 
     * @return void
     */
    protected static function addDatasToBlueprint($datas, $blueprint)
    {

        foreach ($datas as $name => $data) {
            $column = $blueprint->{$data->type}($name);

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
        }

    }

    /**
     * Add fields to $blueprint from a $groupe, recursive on sub-groups.
     *
     * @param  array  $group
     * @param  Blueprint  $blueprint
     * 
     * @return void
     */
    protected static function addGroupToBlueprint($group, $blueprint)
    {
        self::addDatasToBlueprint($group->datas, $blueprint);

        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                self::addGroupToBlueprint($group2, $blueprint);
            }
        }
    }

    /**
     * Create database table of the model.
     *
     * @return void
     */
    public static function up()
    {
        $table_name = get_called_class()::getTableName();

        Schema::create($table_name, function (Blueprint $blueprint) {
            $schema = get_called_class()::getSchema();

            if ($schema->id) {
                $blueprint->id();
            }

            if ($schema->timestamps) {
                $blueprint->timestamps();
            }

            if (isset($schema->datas)) {
                self::addDatasToBlueprint($schema->datas, $blueprint);
            }

            if (isset($schema->groups)) {
                foreach ($schema->groups as $group) {
                    self::addGroupToBlueprint($group, $blueprint);
                }
            }
        });
    }

    /**
     * Cancel a creation of table in the database.
     *
     * @return void
     */
    public static function down()
    {
        Schema::dropIfExists(get_called_class()::getTableName());
    }

    /**
     * Static function to get a validation rules in array format.
     * 
     * @return array
     */
    public static function getValidationRules()
    {
        $rules = [];

        $schema = get_called_class()::getSchema();

        foreach ($schema->groups as $name => $group) {

            foreach ($group->datas as $nameD => $data) {
                if ($data->nullable) {
                    $rules[$nameD] = 'nullable';
                }

                if ($data->unique) {
                    $rules[$nameD] .= '|unique:'.get_called_class()::getTableName();
                }

                if ($data->required) {
                    $rules[$nameD] .= '|required';
                }

                if (isset($data->validation)) {
                    $rules[$nameD] .= '|'.$data->validation;
                }

                /**
                 * If the max is set, add the max rule.
                 */
                if (isset($data->max)) {
                    $rules[$nameD] .= '|max:'.$data->max;
                }
            }
            
        }

        return $rules;
    }
}
