<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Get all books of an author.
     *
     * @param  integer $id author ID
     * @return Illuminate\Http\Response
     */
    public function books($author_slug)
    {
        $author = Author::cache($author_slug);
        $books = Author::cache("{$author_slug}_books");
        return view('authors.books', compact('author', 'books'));
    }

}
