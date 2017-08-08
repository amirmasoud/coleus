<?php

namespace App\Models\Author;

use Cache;
use Carbon\Carbon;
use App\Models\Author;

trait Methods
{
    /**
     * Get author age.
     *
     * @return integer
     */
    public function age()
    {
        return Carbon::now()->year -
            Carbon::createFromFormat('Y-m-d', $this->born)->year;
    }
}
