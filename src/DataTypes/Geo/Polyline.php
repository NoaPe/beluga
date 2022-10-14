<?php

namespace NoaPe\Beluga\DataTypes\Geo;

class Polyline extends MultiPoint
{
    /**
     * Input type
     */
    public $input_type = 'geo.polyline';

    /**
     * Length of the polyline.
     */
    public function length()
    {
        $length = 0;
        $points = $this->shell->getAttribute($this->name);

        for ($i = 0; $i < count($points) - 1; $i++) {
            $length += $points[$i]->distanceTo($points[$i + 1]);
        }

        return $length;
    }
}
