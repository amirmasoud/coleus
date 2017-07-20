<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Author\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        $authors = Author::with('books')->get();
        $authors->each(function ($author) {
            $author->has_book = (bool) $author->books->count();
        });
        return $authors;
    }
}
