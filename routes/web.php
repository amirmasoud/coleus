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
require base_path('routes/admin/web.php');
Route::get('{author}', 'AuthorController@books')->name('authors.books');
Route::get('{author}/{book}/sh{index}/{parent?}', 'ReadController@show')->name('reads.show');
Route::get('{author}/{book}/{parent?}', 'BookController@list')->name('books.list');
