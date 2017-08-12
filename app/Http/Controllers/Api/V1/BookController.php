<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\BookRepo;
use App\Repositories\TableRepo;
use App\Repositories\AuthorRepo;
use App\Repositories\ContentRepo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReadController;

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
            return [
                'children' => TableRepo::routeChildren($book->id),
                'author'   => $author->v1Json(),
                'book'     => $book->v1Json()
            ];
        }
        if (TableRepo::isMultiLevel($book->id) && !is_null($parent)) {
            return [
                'leaves' => TableRepo::leavesOfParent($book->id, TableRepo::slug($parent)->id),
                'author' => $author->v1Json(),
                'book'   => $book->v1Json(),
                'parent' => $parent
            ];
        }
        if ($book->pages == 1) {
            return (new ReadController())->show($author->slug, $book->slug, 1);
        } else {
            return [
                'leaves' => TableRepo::leaves($book->id),
                'author' => $author->v1Json(),
                'book'  => $book->v1Json()
            ];
        }
    }
}
