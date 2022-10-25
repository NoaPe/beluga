<?php

namespace NoaPe\Beluga\Http\Controllers;

use NoaPe\Beluga\ShellController;

class TableController extends ShellController
{
    use Concerns\HasSubGroups;

    protected $layout = 'beluga::layouts.default';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->setRelations();
    }
}
