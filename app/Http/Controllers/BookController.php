<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Table;
use App\Models\Content;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * List of content of the book.
     * @param  integer $author_slug
     * @param  integer $book_slug
     * @param  integer|null $section
     * @return Illuminate\Http\Response
     */
    public function list($author_slug, $book_slug, $section = null)
    {
        $author = Author::cache($author_slug);
        $book = Book::cache($book_slug);
        if (Table::cache("{$book->id}_exists") && is_null($section)) {
            ///////////
            $list = Content::cache("{$book->id}_list");
            return view('books.list', compact('list', 'author', 'book'));
        } else {
            if ($book->pages == 1) {
                ////////////
                return redirect()->route('reads.show', ['author'=>$author, 'book'=>$book, 'index'=>1]);
            } else {
                if (! is_null($section)) {
                    /////////////
                    $book_content = Content::cache("{$book->id}_book_{$section}_section");
                } else {
                    $book_content = Table::cache("{$book->id}_book");
                }
                return view('books.index', compact('book_content', 'author', 'book'));
            }
        }
    }
}
