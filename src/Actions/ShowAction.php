<?php

namespace NoaPe\Beluga\Actions;

use NoaPe\Beluga\Action;

class ShowAction extends Action
{
    protected static $component = 'beluga::components.actions.show';

    public static function render($line)
    {
        return view(static::$component, [
            'id' => $line->id,
            'route' => route($line->getRoute().'.show', [$line::getElementName() => $line->id]),
        ]);
    }
}
