<?php

namespace NoaPe\Beluga\Http\Shells;

use NoaPe\Beluga\Http\Models\BasicShell;

class Permission extends BasicShell
{
    /**
     * Belongs to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('beluga.user_model'));
    }
}
