<?php

namespace NoaPe\Beluga\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NoaPe\Beluga\Beluga
 */
class Beluga extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \NoaPe\Beluga\Beluga::class;
    }
}
