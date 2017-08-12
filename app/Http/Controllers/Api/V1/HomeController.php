<?php

namespace App\Http\Controllers\Api\V1;

use Cache;
use Illuminate\Http\Request;
use App\Repositories\AuthorRepo;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        foreach (AuthorRepo::all() as $author) {
            $authors[] = $author->v1Json();
        }
        return( ['authors' => $authors]);
    }
}
