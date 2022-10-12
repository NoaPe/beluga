<?php

namespace NoaPe\Beluga\Actions;

use NoaPe\Beluga\Action;

class EditAction extends Action
{
    protected static $component = 'beluga::components.actions.edit';

    public static function render($line)
    {
        return view(static::$component, [
            'id' => $line->id,
            'route' => route($line->getRoute().'.edit', [$line::getElementName() => $line->id]),
        ]);
    }
}
