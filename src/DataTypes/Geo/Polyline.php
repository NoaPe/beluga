<?php

namespace NoaPe\Beluga\DataTypes\Geo;

class Polyline extends MultiPoint
{
    /**
     * Render input.
     */
    public function renderInput()
    {
        return view('beluga::components.inputs.'.$this->input_type, [
            'data' => $this,
        ]);
    }

    /**
     * Length of the polyline.
     */
    public function length()
    {
        $length = 0;
        $points = $this->get();

        for ($i = 0; $i < count($points) - 1; $i++) {
            $length += $points[$i]->distanceTo($points[$i + 1]);
        }

        return $length;
    }
}
