<?php

namespace NoaPe\Beluga\Concerns;

trait HasSeeding
{
    /**
     * Seed the database with the number of line.
     *
     * @param  int  $number
     * @return void
     */
    public static function seed($number = 1)
    {
        $class = static::class;
        $shell = new $class();
        $schema = $shell->getSchema();

        echo "Start seeding {$class}...\n";

        $datas = [];

        for ($i = 0; $i < $number; $i++) {
            $datas[] = [];
        }

        $datas = static::seedGroup($datas, $schema, $shell, $number);

        $shell::insert($datas);

        echo "Done seeding {$class} !\n";
    }

    /**
     * Seed a group, recursive on sub-groups.
     *
     * @param  array  $datas
     * @param  mixed  $group
     * @param  \NoaPe\Beluga\Shell  $shell
     * @param  int  $number
     * @return array
     */
    protected static function seedGroup($datas, $group, $shell, $number)
    {
        if (isset($group->datas)) {
            foreach ($group->datas as $data) {
                if ($data->getType($shell)->blueprint_type
                    && ($data->getType($shell)->is('fillable') || $data->getType($shell)->is('required'))) {
                    $values = $data->getType($shell)->generateSeedValues($number);

                    for ($i = 0; $i < $number; $i++) {
                        $datas[$i][$data->name] = $values[$i];
                    }
                }
            }
        }

        if (isset($group->groups)) {
            foreach ($group->groups as $group2) {
                $datas = static::seedGroup($datas, $group2, $shell, $number);
            }
        }

        return $datas;
    }
}
