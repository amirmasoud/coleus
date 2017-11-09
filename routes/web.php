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

// Auth routes

Auth::routes();

// Home route
Route::get('/', 'HomeController@index')->name('home');

// Admin routes
require base_path('routes/admin/web.php');

Route::get('{author}', 'AuthorController@books')->name('authors.books');
Route::get('{author}/{book}/sh{index}/{parent?}', 'ReadController@show')
    ->name('reads.show')
    ->where('index', '[0-9]+');
Route::get('{author}/{book}/{parent?}', 'BookController@list')->name('books.list');
Route::post('comment', 'CommentController@post')->name('comment');
