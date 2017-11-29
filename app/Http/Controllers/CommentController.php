<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest as Request;

class CommentController extends Controller
{
    /**
     * Post a new comment on a content.
     * @param  Request $request
     * @return Redirect
     */
    public function post(Request $request)
    {
        Comment::create($request->all());
        flash()->success('دیدگاه شما پس از بررسی منتشر خواهد شد.');
        return back();
    }
}
