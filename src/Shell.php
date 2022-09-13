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
    public $schema = [];

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
                $data = $table->getRawSchema();
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
     * Recursive static function for get the schema of group with instanciate data types.
     */
    protected static function getGroupSchema($group)
    {
        /**
         * If groups is set, replace each sub group with call to this function.
         */
        if (isset($group->groups)) {
            foreach ($group->groups as $key => $value) {
                $group->groups[$key] = get_called_class()::getGroupSchema($value);
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
     * Static function who take raw schema array and return a schema array with the correct instanciate data types.
     */
    protected static function getSchema()
    {
        /**
         * Get raw schema information.
         */
        $schema = get_called_class()::getRawSchema();

        return get_called_class()::getGroupSchema($schema);
    }

    /**
     * Static function to get table name.
     */
    protected static function getTableName()
    {
        return Str::snake(Str::pluralStudly(class_basename(get_called_class())));
    }

    

    /**
     * Static function for register itself to the ShellComponentProvider
     */
    public static function register()
    {
        Beluga::registerShell(get_called_class());
    }

    /**
     * Add data to $blueprint from a $datas array.
     *
     * @param  array  $datas
     * @param  Blueprint  $blueprint
     * @return void
     */
    protected static function addDataToBlueprint($datas, $blueprint)
    {
        foreach ($datas as $data) {
            $data->addToBlueprint($blueprint);
        }
    }

    /**
     * Add fields to $blueprint from a $group, recursive on sub-groups.
     *
     * @param  array  $group
     * @param  Blueprint  $blueprint
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

            $blueprint->id();

            $blueprint->timestamps();

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

        // TO DO

        return $rules;
    }

    /**
     * Function who use set function of appropriate data type and set attrbute
     *
     * @param  string  $key
     * @param  string  $value
     */
    public function setAttribute($key, $value)
    {
        $data = $this->getDataType($key);

        if ($data) {
            $value = $data->set($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Function who use get function of appropriate data type and return attribute.
     *
     * @param  string  $key
     */
    public function getAttribute($key)
    {
        $data = $this->getDataType($key);

        if ($data) {
            return $data->get(parent::getAttribute($key));
        }

        return parent::getAttribute($key);
    }

    /**
     * Function for get a data type from exploration of the schema.
     *
     * @param  string  $key
     * @param  array  $group
     * @return \Beluga\DataTypes\DataType
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

                if ($data) {
                    return $data;
                }
            }
        }

        return null;
    }
}
