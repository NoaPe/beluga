<?php

namespace NoaPe\Beluga\Http\Policies;

use NoaPe\Beluga\Auth\Policies\RestPolicy;

class DataPolicy extends RestPolicy
{
    /**
     * Table name
     *
     * @var string
     */
    public $table_name = 'beluga_datas';
}
