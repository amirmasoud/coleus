<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
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
        $author = Author::cache($author_id);
        $book = Book::cache($book_id);
        $poem = Content::cache("{$key}_poem_{$book_id}_book_{$section}_section");
        //////////
        $next = Content::cache("{$poem->id}_poem_{$poem->book_id}_book_{$section}_section_next");
        $prev = Content::cache("{$poem->id}_poem_{$poem->book_id}_book_{$section}_section_prev");
        // $next = ($key < $count) ? $key+1 : '#';
        // $prev = ($key > 1) ? $key-1 : '#';
        $poem = json_decode($poem->value);
        $title = (isset($poem->tite)) ? $poem->title : '';
        unset($poem->title);
        return view('reads.show', compact('poem', 'author', 'book', 'key', 'next', 'prev', 'title', 'section'));
    }
}
