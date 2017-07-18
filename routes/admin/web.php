<?php
/**
 * Main admin route files.
 */

Route::group(['namespace' => 'Admin',
              'prefix' => 'admin',
              'middleware' => ['auth', 'role:admin']], function () {
                  Route::resource('books', 'BookController');
                  Route::resource('publishers', 'PublisherController');
                  Route::resource('categories', 'CategoryController');
                  Route::resource('authors', 'AuthorController');
                  Route::resource('occupations', 'OccupationController');
                  Route::resource('movements', 'MovementController');
                  Route::resource('sliders', 'SliderController');
                  Route::get('dashboard', 'DashboardController@index')->name('dashboard');
              });
