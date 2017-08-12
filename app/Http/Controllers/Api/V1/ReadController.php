<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\BookRepo;
use App\Repositories\AuthorRepo;
use App\Repositories\ContentRepo;
use App\Http\Controllers\Controller;

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
        $content->text = [$content->text];
        unset($next->content, $prev->content);
        return [
            // 'author' => $author->v1Json(),
            // 'book' => $book,
            'content' => $content,
            'next' => ($next == '#') ? '#' : $next,
            'prev' => ($prev == '#') ? '#' : $prev,
        ];
    }
}
