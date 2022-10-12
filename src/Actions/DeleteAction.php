<?php

namespace NoaPe\Beluga\Actions;

use NoaPe\Beluga\Action;

class DeleteAction extends Action
{
    protected static $component = 'beluga::components.actions.delete';

    static function render($line)
    {
        return view(static::$component, [
            'id' => $line->id,
            'route' => route($line->getRoute().'.destroy', [$line::getElementName() => $line->id])
        ]);
    }
}