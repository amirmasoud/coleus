<?php

namespace App\Http\Controllers\Admin;

use Cache;
use App\Models\Table;
use App\Models\Author;
use App\Models\Publisher;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TableRequest as Request;

class TableController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $table->fill($request->all())->save();
        flash('Table updated.');
        return redirect()->route('books.index');
    }
}
