<?php

namespace NoaPe\Beluga\Helpers;

class Point
{
    /**
     * Latitude.
     * 
     * @var float
     */
    public $lat;

    /**
     * Longitude.
     * 
     * @var float
     */
    public $lng;

    /**
     * Constructor for instantiate a point.
     * 
     * @param float $lat
     * @param float $lng
     * @return void
     */
    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * Get the distance between two points.
     * 
     * @param  Point  $point
     * @return float
     */
    public function distanceTo($point)
    {
        $lat1 = $this->lat;
        $lng1 = $this->lng;
        $lat2 = $point->lat;
        $lng2 = $point->lng;

        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $dist = $earthRadius * $c;

        return $dist;
    }

    /**
     * Get the point as an array.
     * 
     * @return array
     */
    public function toArray()
    {
        return [
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }

    /**
     * Get the point as a string.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->lat . ':' . $this->lng;
    }
}