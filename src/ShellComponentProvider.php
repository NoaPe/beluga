<?php

namespace NoaPe\Beluga;

use Illuminate\Support\Facades\Blade;
use NoaPe\Beluga\Http\Components\Form;
use NoaPe\Beluga\Http\Components\Input;
use NoaPe\Beluga\Http\Components\Table;
use NoaPe\Beluga\Http\Components\Group;

class ShellComponentProvider
{
    /**
     * Register all the components for a shell.
     *
     * @return void
     */
    public static function register()
    {
        Blade::component(Form::class, 'beluga-form');
        Blade::component(Table::class, 'beluga-table');
        Blade::component(Group::class, 'beluga-group');
        Blade::component(Input::class, 'beluga-input');
    }
}
