<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuthorRepo;

class AuthorController extends Controller
{
    /**
     * Get all books of the author.
     *
     * @param  integer $author
     * @return Illuminate\Http\Response
     */
    public function books($author)
    {
        $author = AuthorRepo::slug($author, 'books');
        return view('authors.books', compact('author'));
    }

}
