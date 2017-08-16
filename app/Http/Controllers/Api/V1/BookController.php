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
     *
     * @param  string $slug
     * @param  string $parent
     * @return Illuminate\Http\Response
     */
    public function list($slug, $parent = null)
    {
        return TableRepo::API_list($slug, $parent);
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
