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
    /**
     * Get all books of an author.
     *
     * @param  integer $id author ID
     * @return Illuminate\Http\Response
     */
    public function index(Author $author)
    {        
        $books = $author->books;
        return view('author.books', compact('books'));
    }

    public function book(Author $author, Book $book, $section = null)
    {
        $content = Content::where('type', 'section')->where('book_id', $book->id);
        if ($content->exists() && is_null($section)){
            $list = $content->get();
            return view('author.sections', compact('list', 'author', 'book'));
        } else {
            if ($book->pages == 1) {
                return redirect()->route('author.books.show', ['author'=>$author, 'book'=>$book, 'index'=>1]);
            } else {
                if (! is_null($section)) {
                    $book_content = Content::where('type', 'poem')
                                        ->where('book_id', $book->id)
                                        ->where('content_id', $section)
                                        ->orderBy('key')->get();
                } else {
                    $book_content = Content::where('type', 'poem')
                                        ->where('book_id', $book->id)
                                        ->orderBy('key')->get();
                }
                return view('author.book', compact('book_content', 'author', 'book'));
            }
        }
    }

    public function show($author_id, $book_id, $index)
    {
        $author = Author::find($author_id);
        $book = Book::find($book_id);
        $poem = Content::where('book_id', $book_id)->where('type', 'poem')->where('key', $index)->first();
        $count = Content::where('content_id', $poem->content_id)->count();
        $next = ($index < $count) ? $index+1 : '#';
        $prev = ($index > 1) ? $index-1 : '#';
        $poem = json_decode($poem->value);
        $title = '';
        // $author = Author::cached($author_id);
        // $book = Book::cached($book_id);
        // $poem = Poem::cached($book_id, $index);
        // $count = Book::cached($book_id, 'count');
        // $next = Book::next($index, $count);
        // $prev = Book::prev($index, $count);
        // $title = Poem::title($book_id, $index, $poem);
        // unset($poem->title);
        return view('author.show', compact('poem', 'author', 'book', 'index', 'next', 'prev', 'title'));
    }
}
