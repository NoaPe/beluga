<?php

namespace NoaPe\Beluga\Actions;

use NoaPe\Beluga\Action;

class DownloadAction extends Action
{
    protected static $component = 'beluga::components.actions.download';

    static function render($line)
    {
        return view(static::$component, [
            'id' => $line->id,
            'route' => route($line->getRoute().'.edit', [$line::getElementName() => $line->id])
        ]);
    }
}