<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\BookRepo;
use App\Repositories\TableRepo;
use App\Repositories\AuthorRepo;
use App\Repositories\ContentRepo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\ReadController;

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
                'children' => TableRepo::leavesOfParent($book->id, TableRepo::slug($parent)->id),
                'author' => $author->v1Json(),
                'book'   => $book->v1Json(),
                'parent' => $parent
            ];
        }
        if ($book->pages == 1) {
            return (new ReadController())->show($author->slug, $book->slug, 1);
        } else {
            $leaves = [];
            foreach (TableRepo::leaves($book->id) as $leaf) {
                unset($leaf->text);
                $leaves[] = $leaf;
            }
            return [
                'children' => $leaves,
                'author' => $author->v1Json(),
                'book'  => $book->v1Json()
            ];
        }
    }

    /**
     * Get books of author.
     *
     * @param  string $slug Author's slug
     * @return Collection
     */
    public function author($slug)
    {
        return ['books' => BookRepo::API_author($slug)];
    }
}
