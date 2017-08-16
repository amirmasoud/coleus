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
        return(['authors' => AuthorRepo::API_all()]);
    }
}
