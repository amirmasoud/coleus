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
require base_path('routes/admin/web.php');

// Auth routes
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('authors/{author}/books/', 'AuthorController@books')->name('authors.books');
Route::get('authors/{author}/books/{book}/{section?}', 'BookController@list')->name('books.list');
Route::get('author/{author}/{book}/{index}/{section?}', 'ReadController@show')->name('reads.show');
