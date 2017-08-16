<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Repositories\AuthorRepo;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    /**
     * Get all books of the author.
     *
     * @param  integer $author
     * @return Illuminate\Http\Response
     */
    public function books($author)
    {
        return ['author' => AuthorRepo::API_books($author)];
    }

}
