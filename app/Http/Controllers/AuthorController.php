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
    public function books($author_id)
    {
        $author = Author::cache($author_id);
        $books = Author::cache("{$author_id}_books");
        return view('authors.books', compact('author', 'books'));
    }

}
