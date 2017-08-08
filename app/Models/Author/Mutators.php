<?php

namespace App\Models\Author;

use Illuminate\Http\UploadedFile;

trait Mutators
{
    /**
     * Set the approved value.
     *
     * @param  string  $value
     * @return void
     */
    public function setApprovedAttribute($value)
    {
        $this->attributes['approved'] = (bool) $value;
    }

    /**
     * Set the extra value.
     *
     * @param  string  $value
     * @return void
     */
    public function setExtraAttribute($value)
    {
        $newValue = [];
        for ($i = 0; $i < count($value); $i += 2) {
            if ($value[$i] != '' && !is_null($value[$i])) {
                if ($value[$i] instanceof UploadedFile) {
                    $value[$i] = basename($value[$i]->store('public/covers'));
                    $newValue['cover'] = $value[$i];
                } else {
                    $newValue[$value[$i]] = $value[$i + 1];
                }
            }
        }
        $this->attributes['extra'] = serialize($newValue);
    }
}
