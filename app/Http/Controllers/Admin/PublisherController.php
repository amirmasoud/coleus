<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Publisher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\PublisherRequest as Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishers = Publisher::orderBy('updated_at', 'desc')
                               ->paginate(config('admin.perPage'));
        return view('admin.publishers.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.publishers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Admin\PublisherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->openNewPublisher($request);
        flash('New publisher added');
        return redirect()->route('publishers.index');
    }

    /**
     * Open a new publisher.
     * @param  App\Http\Requests\Admin\PublisherRequest  $request
     * @return void
     */
    private function openNewPublisher($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('publishers.create')
                        ->withErrors($validator)
                        ->exceptInput('extra');
        }

        $request['extra'] = [];
        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ])->publisher()->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        return view('admin.publishers.show', compact('publisher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher    $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Admin\PublisherRequest  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        $publisher->fill($request->all())->save();
        flash('Publisher updated.');
        return redirect()->route('publishers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()->route('publishers.index');
    }
}
