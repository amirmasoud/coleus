<?php

namespace App\Http\Controllers;

use App\Models\Author\Model as Author;
use App\Models\Book;
use App\Models\Content;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    /**
     * Show content of a book.
     * @param  integer $author_id
     * @param  integer $book_id
     * @param  integer $index
     * @return Illuminate\Http\Response
     */
    public function show($author_id, $book_id, $key, $section = null)
    {
        $author = Author::cached($author_id);
        $book = Book::cached($book_id);
        $poem = Content::cachedPoem($key, $book_id, $section);
        $count = Content::cachedCount($poem->content_id);
        $next = ($key < $count) ? $key+1 : '#';
        $prev = ($key > 1) ? $key-1 : '#';
        $poem = json_decode($poem->value);
        $title = '';
        return view('reads.show', compact('poem', 'author', 'book', 'key', 'next', 'prev', 'title', 'section'));
    }
}
