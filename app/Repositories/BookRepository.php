<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository extends Repository
{
    /**
     * @param  string $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        $slug = explode('-', $slug);
        $id = end($slug);
        return Book::whereId($id);
    }
}
