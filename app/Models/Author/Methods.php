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

    /**
     * Get V1 json values.
     * 
     * @return array
     */
    public function v1Json()
    {
        $author = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'cover' => asset('storage/covers/' . $this->extra['cover']),
            'books' => $this->books
        ];
        return $author;
    }
}
