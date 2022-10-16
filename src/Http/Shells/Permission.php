<?php

namespace NoaPe\Beluga\Shells;

use NoaPe\Beluga\Shell;

class Permission extends Shell
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