<?php

namespace NoaPe\Beluga;

use Illuminate\Support\Facades\Blade;

class ShellComponentProvider
{
    /**
     * Register all the components for a shell.
     *
     * @return void
     */
    public static function register()
    {
        Blade::component(\NoaPe\Beluga\Http\Components\Form::class, 'beluga-form');
        Blade::component(\NoaPe\Beluga\Http\Components\Table::class, 'beluga-table');
        Blade::component(\NoaPe\Beluga\Http\Components\Group::class, 'beluga-group');
        Blade::component(\NoaPe\Beluga\Http\Components\Input::class, 'beluga-input');
        Blade::component(\NoaPe\Beluga\Http\Components\Field::class, 'beluga-field');

        Blade::component(\NoaPe\Beluga\Http\Components\Import::class, 'beluga-import');

        Blade::componentNamespace('\\NoaPe\\Beluga\\Http\\Components', 'beluga');
    }
}
