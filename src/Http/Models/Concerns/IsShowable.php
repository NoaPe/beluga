<?php

namespace NoaPe\Beluga\Http\Models\Concerns;

trait IsShowable
{
    public function show($shell)
    {
        return view('beluga::components.show-group', [
            'group' => $this,
            'shell' => $shell,
        ]);
    }
}
