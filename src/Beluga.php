<?php

namespace NoaPe\Beluga;

class Beluga
{
    /**
     * Static function for get the data type class from array in the config file.
     */
    public static function getDataType($type)
    {
        $data_types = config('beluga.data_types');

        if (isset($data_types[$type])) {
            return $data_types[$type];
        }

        throw new \Exception('Unknown data type: '.$type);
    }

    /**
     * Static function for get shell from his name.
     */
    public static function getShell($name)
    {
        // Test if the shell exist in the config namespace.
        $class = config('beluga.shell_namespace').'\\'.$name;

        if (class_exists($class)) {
            return $class;
        }

        // Test if the shell exist in the internal shell namespace.
        $class = config('beluga.internal_shell_namespace').'\\'.$name;

        if (class_exists($class)) {
            return $class;
        }

        return $name;
    }
}
