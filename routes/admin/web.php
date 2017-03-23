<?php
/**
 * Main admin route files.
 */

Route::group(['namespace' => 'Admin',
              'prefix' => 'admin',
              'middleware' => 'auth'], function () {
                  Route::resource('occupations', 'OccupationController');
                  Route::resource('movements', 'MovementController');
                  Route::resource('sliders', 'SliderController');
                  Route::get('dashboard', 'DashboardController@index')->name('dashboard');
              });
