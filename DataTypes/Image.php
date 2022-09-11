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
     * Constructor
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->image_path = config('beluga.image_path');
    }
}
