<?php

namespace NoaPe\Beluga\Concerns;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait HasBlueprint
{
    /**
     * Add data to $blueprint from a $datas array.
     *
     * @param  array  $datas
     * @param  Blueprint  $blueprint
     * @return void
     */
    protected static function addDatasToBlueprint($datas, $blueprint)
    {
        foreach ($datas as $data) {
            $data->addToBlueprint($blueprint);
        }
    }

    /**
     * Add fields to $blueprint from a $group, recursive on sub-groups.
     *
     * @param  mixed  $group
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
            $schema = get_called_class()::getJsonSchema();

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
}
