<?php
/**
 * Main admin route files.
 */

Route::group(['namespace' => 'Admin',
              'prefix' => 'admin',
              'middleware' => 'auth'], function () {
                  require 'sliders.php';
                  Route::get('dashboard', 'DashboardController@index')->name('dashboard');
              });