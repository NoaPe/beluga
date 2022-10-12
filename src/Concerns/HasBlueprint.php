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
            $class = static::class;
            $data->getType(new $class())->addToBlueprint($blueprint);
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
        if (isset($group->datas)) {
            self::addDatasToBlueprint($group->datas, $blueprint);
        }

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
        $table_name = static::getTableName();

        Schema::create($table_name, function (Blueprint $blueprint) {
            $class = static::class;
            $schema = (new $class())->getSchema();

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
        Schema::dropIfExists(static::getTableName());
    }
}
