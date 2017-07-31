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
     * @param  integer $author_slug
     * @param  integer $book_slug
     * @param  integer $index
     * @return Illuminate\Http\Response
     */
    public function show($author_slug, $book_slug, $index, $section = null)
    {
        $author = Author::cache($author_slug);
        $book = Book::cache($book_slug);
        $content = Content::cache("{$index}_poem_{$book_slug}_book_{$section}_section", $book);
        $next = Content::cache("{$content->id}_content_{$content->book_slug}_book_{$section}_section_next", $book);
        $prev = Content::cache("{$content->id}_content_{$content->book_slug}_book_{$section}_section_prev", $book);
        $content = json_decode($content->text);
        $title = (isset($content->tite)) ? $content->title : '';
        $unit = (isset($content->unit)) ? $content->unit : '';
        // unset($content->title, $content->unit);
        return view('reads.show', compact('content', 'author', 'book', 'index', 'next', 'prev', 'title', 'unit', 'section'));
    }
}
