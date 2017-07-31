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
// Admin routes

// Auth routes
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('{author}', 'AuthorController@books')->name('authors.books');
Route::get('{author}/{book}', 'BookController@list')->name('books.list');
Route::get('{author}/{book}/sh{index}', 'ReadController@show')->name('reads.show');

require base_path('routes/admin/web.php');
