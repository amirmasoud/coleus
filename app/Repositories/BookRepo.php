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

    /**
     * Prepare json for book.
     * @param  Collection|\App\Models\Book $book
     * @return array
     */
    public static function formatted($book)
    {
        if ($book instanceof Book) {
            return [
                'title' => $book->title,
                'slug'  => $book->slug,
                'cover' => asset('storage/covers/' . $book->extra['cover']),
            ];
        } else {
            $formatted = [];
            foreach ($book as $b) {
                $formatted[] = [
                    'title' => $b->title,
                    'slug'  => $b->slug,
                    'cover' => asset('storage/covers/' . $b->extra['cover']),
                ];
            }
            return $formatted;
        }
    }
}
