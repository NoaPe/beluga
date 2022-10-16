<?php

namespace NoaPe\Beluga;

class Action
{
    /**
     * Component name.
     *
     * @var view-string
     */
    protected static $component = null;

    /**
     * Render the action.
     *
     * @param  \NoaPe\Beluga\Shell  $line
     * @return \Illuminate\View\View
     */
    public static function render($line)
    {
        return view(static::$component, [
            'id' => $line->id,
        ]);
    }
}
