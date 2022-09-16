<?php

namespace NoaPe\Beluga\DataTypes\Geo;

class Polygon extends MultiPoint
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
}
