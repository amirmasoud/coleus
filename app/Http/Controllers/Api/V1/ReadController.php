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
    public function slug($slug)
    {
        return [
            'content' => ContentRepo::API_slug($slug),
            'next'   => ContentRepo::API_next($slug),
            'prev' => ContentRepo::API_prev($slug),
        ];
    }
}
