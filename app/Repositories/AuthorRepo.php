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

    /**
     * Get all authors.
     *
     * @return Collection
     */
    public static function API_all()
    {
        return Cache::remember('api:author:*', 60*24*7, function() {
            $authors = Author::orderBy('slug', 'desc')->get(['id', 'name', 'slug', 'extra']);
            $formated = [];
            foreach ($authors as $author) {
                $formated[] = [
                    'id' => $author->id,
                    'name' => $author->name,
                    'slug' => $author->slug,
                    'cover' => asset('storage/covers/' . $author->extra['cover']),
                ];
            }
            return $formated;
        });
    }
}
