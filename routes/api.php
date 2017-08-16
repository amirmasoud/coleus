<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api\V1'], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('content/{slug}', 'ReadController@slug')->name('reads.slug');
    Route::get('author/{slug}/books', 'AuthorController@books')->name('author.books');
    // Route::get('{author}', 'AuthorController@books')->name('authors.books');
    Route::get('{author}/{book}/sh{index}/{parent?}', 'ReadController@show')->name('reads.show');
    Route::get('{author}/{book}/{parent?}', 'BookController@list')->name('books.list');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
