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
     * Get the author by cache server.
     * 
     * @param  integer $ucid Unique Cache ID
     * @return \App\Models\Author
     */
    public static function cache($ucid)
    {
        $cache_key = config('app.name') . '_author_' . $ucid;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            if ($ucid == '*') {
                $cache_value = Author::get();
            } else if (strpos($ucid, 'books')) {
                // {author_slug}_books
                $cache_value = Author::where('slug', explode('_', $ucid)[0])
                                    ->first()->books;
            } else {
                $cache_value = Author::where('slug', $ucid)->first();
            }
            Cache::forever($cache_key, $cache_value);
            return $cache_value;
        }
    }
}
