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
     * Static function for register a shell ine the ShellComponentProvider.
     */
    public static function registerShell($shell)
    {
        ShellComponentProvider::register(config('beluga.shell_namespace').'\\'.class_basename($shell));
    }

    /**
     * Static function for register a internal shell ine the ShellComponentProvider.
     */
    public static function registerInternalShell($shell)
    {
        ShellComponentProvider::register(config('beluga.internal_shell_namespace').'\\'.class_basename($shell));
    }
}
