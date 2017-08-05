<?php

namespace App\Http\Controllers;

use Cache;
use App\Models\Author;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Cache::remember('author:*', 60*24*7, function() {
            return Author::get();
        });
        return view('home', compact('authors'));
    }
}
