<?php

namespace App\Http\Controllers\Admin;

use Cache;
use App\Models\Content;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentRequest as Request;

class ContentController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        $content->fill($request->all())->save();
        flash('Content updated.');
        return redirect()->route('books.index');
    }
}
