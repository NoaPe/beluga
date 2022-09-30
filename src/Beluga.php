<?php

namespace NoaPe\Beluga;

use Illuminate\Support\Facades\Route;

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
     *
     * @param  string  $name
     * @return string
     */
    public static function qualifyShell($name)
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

    /**
     * Static function for qualify a controller from shell name.
     *
     * @param  string  $name
     * @return string
     */
    public static function qualifyController($name)
    {
        $class = config('beluga.controller_namespace').'\\'.$name.'Controller';

        if (class_exists($class)) {
            return $class;
        }

        return $name;
    }

    /**
     * Create resource from class
     *
     * @param  string  $class
     */
    public static function createResource($shell)
    {
        $controller = self::qualifyController($shell);
        $shell = self::qualifyShell($shell);
        $route = (new $shell())->getRoute();

        Route::resource(config('beluga.api_prefix').'/'.$route, $controller);
    }
}
