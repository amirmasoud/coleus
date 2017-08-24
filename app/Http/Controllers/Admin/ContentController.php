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
        $text =json_encode($request->text);
        $request['hash'] = md5($text . '-' . $request->html . '-' . $content->table->id . '-' . $content->order);
        $content->fill($request->all())->save();
        $parent = $content->table->parent->slug;
        Cache::forget("content:{$content->order}:book:{$content->table->book->id}:parent:{$parent}");
        Cache::forget("content:{$content->order}:book:{$content->table->book->id}:parent:");
        flash('Content updated.');
        return redirect()->route('tables.edit', ['table' => $content->table]);
    }
}
