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
                $author = Author::get();
            } else {
                $author = Author::find($ucid);
            }
            Cache::forever($cache_key, $author);
            return $author;
        }
    }
}
