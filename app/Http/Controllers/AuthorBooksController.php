<?php

namespace App\Http\Controllers;

use Cache;
use App\Models\Book;
use App\Models\Poem;
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

    public function book(Author $author, Book $book)
    {
        $content = json_decode($book->content);
        if ($book->pages == 1) {
            return redirect()->route('author.books.show', ['author'=>$author, 'book'=>$book, 'index'=>1]);
        } else {
            $count = count($content);
            return view('author.book', compact('count', 'author', 'book'));
        }
    }

    public function show($author_id, $book_id, $index)
    {
        $author = Author::cached($author_id);
        $book = Book::cached($book_id);
        $poem = Poem::cached($book_id, $index);
        $count = Book::cached($book_id, 'count');
        $next = Book::next($index, $count);
        $prev = Book::prev($index, $count);
        $title = Poem::title($book_id, $index, $poem);
        unset($poem->title);
        return view('author.show', compact('poem', 'author', 'book', 'index', 'next', 'prev', 'title'));
    }
}
