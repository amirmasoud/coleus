<?php

namespace App\Http\Controllers;

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
        // TODO: add featured flag to show on home page
        $authors = Author::get();
        return view('home', compact('authors'));
    }
}
