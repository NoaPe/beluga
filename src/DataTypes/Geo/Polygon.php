<?php

namespace NoaPe\Beluga\DataTypes\Geo;

class Polygon extends MultiPoint
{
    /**
     * Input type
     */
    public $input_type = 'geo.polygon';

    /**
     * Surface of the polygon.
     * 
     * @return float
     */
    public function surface()
    {
        $surface = 0;
        $points = $this->shell->getAttribute($this->name);

        if (count($points) > 2) {
            for ($i = 0; $i < count($points) - 1; $i++) {
                $lat = $points[$i]->latKm();
                $lng = $points[$i]->lngKm();
                $lat2 = $points[$i + 1]->latKm();
                $lng2 = $points[$i + 1]->lngKm();

                $surface += ($lat * $lng2) - ($lat2 * $lng);
            }
        } else {
            return 0;
        }

        return abs($surface / 2);
    }
}
