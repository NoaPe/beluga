<?php

namespace NoaPe\Beluga\Http\Components;

class Field extends Input
{
    public function render()
    {
        $data = $this->getData();
        
        // Return the view from the data type
        return $data->getType($this->shell)->renderField();
    }
}
