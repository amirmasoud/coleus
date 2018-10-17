<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Stick extends Model
{
    /**
     * Get all of the owning stickable models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function stickable(): MorphTo
    {
        return $this->morphTo();
    }
}
