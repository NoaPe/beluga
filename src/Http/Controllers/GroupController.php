<?php

namespace NoaPe\Beluga\Http\Controllers;

use NoaPe\Beluga\ShellController;

class GroupController extends ShellController
{
    use Concerns\HasSubGroups;

    protected $layout = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->setRelations();
    }
}
