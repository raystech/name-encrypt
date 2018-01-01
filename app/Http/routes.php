<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('dir/walk', 'DirController@walk')->name('walk');
Route::get('dir/encrypt', 'DirController@encrypt')->name('encrypt');
Route::resources([
    'dir' => 'DirController',
    'posts' => 'PostController'
]);

