<?php

namespace App\Http\Controllers\Admin;

use Cache;
use App\Models\User;
use App\Models\Author\Model;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\AuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::with('user')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(config('admin.perPage'));
        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Admin\AuthorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorRequest $request)
    {
        $this->bornAnAuthor($request);
        Cache::forget(config('app.name') . '_author_*')
        flash('New author added');
        return redirect()->route('authors.index');
    }

    /**
     * Born a brand new author with the given informations.
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    private function bornAnAuthor($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('authors.create')
                        ->withErrors($validator)
                        ->exceptInput('extra');
        }

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ])->author()->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return view('admin.authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Admin\AuthorRequest  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $author->fill($request->all())->save();
        Cache::forget(config('app.name') . '_author_*')
        flash('Author updated.');
        return redirect()->route('authors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index');
    }
}
