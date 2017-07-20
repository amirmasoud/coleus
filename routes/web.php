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

Route::get('/', 'HomeController@index');
Route::get('authors/{author}/books/', 'AuthorController@books')->name('authors.books');
Route::get('authors/{author}/books/{book}/{section?}', 'AuthorBooksController@book')->name('author.books.index');
Route::get('author/{author}/{book}/{index}/{section?}', 'ReadController@show')->name('reads.show');
Route::get('hafez/{id}', function($id) {
    $id = $id - 1;
    // return (json_decode(\App\Models\Book::first()->content));
    foreach(json_decode(\App\Models\Book::first()->content)[$id] as $b) {
        echo '<p>' . $b->m1 . '</p>';
        echo '<p>' . $b->m2 . '</p>';
    }
})->name('hafez');

// Admin routes
require base_path('routes/admin/web.php');

Auth::routes();
