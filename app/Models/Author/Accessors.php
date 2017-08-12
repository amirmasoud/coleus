<?php

namespace App\Models\Author;

use Carbon\Carbon;

trait Accessors {
    /**
     * Get the approved value.
     *
     * @param  string  $value
     * @return string
     */
    public function getApprovedAttribute($value)
    {
        return (bool) $value;
    }

    /**
     * Get the extra value.
     *
     * @param  string  $value
     * @return string
     */
    public function getExtraAttribute($value)
    {
        return unserialize($value);
    }

    /**
     * Get the born value.
     *
     * @param  string  $value
     * @return string
     */
    // public function getBornAttribute($value)
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $value)->toDateString();
    // }
}