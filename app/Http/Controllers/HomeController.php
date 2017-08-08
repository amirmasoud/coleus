<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Repositories\AuthorRepo;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = AuthorRepo::all();
        return view('home', compact('authors'));
    }
}
