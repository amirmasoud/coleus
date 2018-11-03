<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test', function() {


    return \App\Models\User::where('users.id', 14)
        ->with('books', 'books.collaborators')
        ->get();
        // ->with('collaboratables')
        // ->whereHas('collaborators', function ($q) {
        //     $q->where('collaborate_id', 14);
        // })->get();
});

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
