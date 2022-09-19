<?php

namespace NoaPe\Beluga\DataTypes\Geo;

use Illuminate\Database\Schema\Blueprint;
use NoaPe\Beluga\DataType;
use NoaPe\Beluga\Helpers\Point;

abstract class MultiPoint extends DataType
{
    /**
     * Blueprint type.
     */
    public $blueprint_type = 'string';

    /**
     * Set function.
     */
    public function set($value)
    {
        $result = '';

        // For each position in $value, add the lat and lng to the string.
        foreach ($value as $position) {
            $result .= $position->lat.':'.$position->lng.',';
        }

        // Remove the last semicolon.
        $result = substr($result, 0, -1);

        return $result;
    }

    /**
     * Get function.
     */
    public function get($value)
    {
        $value = explode(';', $value);

        $result = [];

        // For each position in $value, add the lat and lng to the array.
        foreach ($value as $position) {
            $position = explode(':', $position);
            $result[] = new Point($position[0], $position[1]);
        }

        return $result;
    }
}
