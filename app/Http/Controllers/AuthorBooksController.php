<?php

namespace App\Http\Controllers;

use Cache;
use App\Models\Book;
use App\Models\Poem;
use App\Models\Content;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorBooksController extends Controller
{
    public function book($author_id, $book_id, $section = null)
    {
        $author = Author::cached($author_id);
        $book = Book::cached($book_id);
        if (Content::cachedExists($book->id) && is_null($section)){
            $list = Content::cachedList($book->id);
            return view('author.sections', compact('list', 'author', 'book'));
        } else {
            if ($book->pages == 1) {
                return redirect()->route('author.books.show', ['author'=>$author, 'book'=>$book, 'index'=>1]);
            } else {
                if (! is_null($section)) {
                    $book_content = Content::cachedPoemWithSection($book->id, $section);
                } else {
                    $book_content = Content::cachedPoemWithoutSection($book->id);
                }
                return view('author.book', compact('book_content', 'author', 'book'));
            }
        }
    }
}
