<?php

namespace App\Repositories;

use Cache;
use App\Models\Book;

class BookRepo extends Repo
{
    /**
     * Find a book by slug.
     *
     * @param  string $slug
     * @return \App\Models\Book
     */
    public static function slug($slug)
    {
        return Cache::remember("book:{$slug}", self::MONTH_IN_MINUTE, function() use ($slug) {
            return Book::where('slug', $slug)->first();
        });
    }
}
