<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Cache::forever()
        $authors = Author::cache('*');
        return view('home', compact('authors'));
    }
}
