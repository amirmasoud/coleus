<?php

namespace App\Http\Controllers;

use App\User;
use App\Book;
use App\Page;
use App\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class SearchController extends Controller
{
    public function query(Request $request)
    {
        if ($request->filled('q')) {
            try {
                return [
                    'users' => User::search($request->q)->get(),
                    'books' => Book::search($request->q)->get(),
                    'pages' => Page::search($request->q)->get(),
                    'blocks' => Block::search($request->q)->get()
                ];
            } catch (QueryException $e) {
                return [];
            }
        } else {
            return [];
        }
    }
}
