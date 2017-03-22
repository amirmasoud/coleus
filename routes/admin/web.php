<?php
/**
 * Main admin route files.
 */

Route::group(['namespace' => 'Admin',
              'prefix' => 'admin',
              'middleware' => 'auth'], function () {
                  Route::resource('sliders', 'SliderController');
                  Route::resource('occupations', 'OccupationController');
                  Route::get('dashboard', 'DashboardController@index')->name('dashboard');
              });
