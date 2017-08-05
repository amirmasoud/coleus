<?php

namespace App\Repositories;

use Cache;
use App\Models\Author;

class AuthorRepo extends Repo
{
    /**
     * Find an author by slug.
     *
     * @param  string $slug
     * @return \App\Models\Author
     */
    public static function slug($slug, ...$with)
    {
        array_unshift($with, $slug);
        return Cache::remember('author:' . implode(':', $with),
            self::MONTH_IN_MINUTE, function () use ($slug, $with) {
                array_shift($with);
                return Author::with($with)->where('slug', $slug)->first() 
                    ?? abort(404);
            });
    }

    /**
     * Get author's books.
     *
     * @param  string $slug
     * @return collection
     */
    public static function books($slug)
    {
        return Cache::remember("author:{$slug}:books",
            self::MONTH_IN_MINUTE, function () use ($slug) {
                return self::slug($slug)->books;
            });
    }
}
