<?php

namespace App\Http\Controllers;

use App\Repositories\BookRepo;
use App\Repositories\AuthorRepo;
use App\Repositories\ContentRepo;

class ReadController extends Controller
{
    /**
     * Show content of a book.
     * @param  integer $author
     * @param  integer $book
     * @param  integer $order
     * @return Illuminate\Http\Response
     */
    public function show($author, $book, $order, $parent = null)
    {
        $author = AuthorRepo::slug($author);
        $book = BookRepo::slug($book);
        $content = ContentRepo::leaf($book->id, $order, $parent);
        $next = ContentRepo::next($book->id, $order, $parent);
        $prev = ContentRepo::prev($book->id, $order, $parent);
        $text = $content->text;
        if(in_array($content->type, ['ghazal', 'masnavi', 'ghate', 'robaee', 'ghaside'])) {
            return view('reads.show', compact('author', 'book', 'content', 'next', 
                                              'prev', 'text', 'parent'));
        } else if (in_array($content->type, ['tarje', 'teke'])) {
            return view('reads.tarje', compact('author', 'book', 'content', 'next', 
                                              'prev', 'text', 'parent'));
        } else if (in_array($content->type, ['text'])) {
            return view('reads.text', compact('author', 'book', 'content', 'next', 
                                              'prev', 'text', 'parent'));
        } else if (in_array($content->type, ['mix'])) {
            return view('reads.mix', compact('author', 'book', 'content', 'next', 
                                              'prev', 'text', 'parent'));
        }
    }
}
