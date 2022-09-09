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
}
