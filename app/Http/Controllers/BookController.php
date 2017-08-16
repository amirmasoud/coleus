<?php

namespace App\Http\Controllers;

use App\Repositories\BookRepo;
use App\Repositories\TableRepo;
use App\Repositories\AuthorRepo;
use App\Repositories\ContentRepo;

class BookController extends Controller
{
    /**
     * List of content of the book.
     * @param  integer $author
     * @param  integer $book
     * @param  integer|null $parent
     * @return Illuminate\Http\Response
     */
    public function list($author, $book, $parent = null)
    {
        $author = AuthorRepo::slug($author);
        $book = BookRepo::slug($book);
        if (TableRepo::isMultiLevel($book->id) && is_null($parent)) {
            $children = TableRepo::routeChildren($book->id);
            return view('books.children', compact('children', 'author', 'book'));
        }
        if (TableRepo::isMultiLevel($book->id) && !is_null($parent)) {
            $leaves = TableRepo::leavesOfParent($book->id, TableRepo::slug($parent)->id);
            return view('books.parent', compact('leaves', 'author', 'book', 'parent'));
        }
        if ($book->pages == 1) {
            return redirect()->route('reads.show', ['author'=>$author->slug,
                                                    'book'=>$book->slug,
                                                    'index'=>1]);
        } else {
            $leaves = TableRepo::leaves($book->id);
            return view('books.index', compact('leaves', 'author', 'book'));
        }
    }
}
