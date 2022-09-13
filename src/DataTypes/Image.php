<?php

namespace NoaPe\Beluga\DataTypes;

use NoaPe\Beluga\DataType;

class Image extends DataType
{
    /**
     * The blueprint_type of the data.
     */
    public $blueprint_type = 'string';

    /**
     * The image file path from the config.
     */
    public $image_path;
    
    /**
     * Html input type.
     */
    public $input_type = 'image';

    /**
     * Constructor
     */
    public function __construct($name, $data)
    {
        parent::__construct($data);
        $this->image_path = config('beluga.image_path');
    }
}
