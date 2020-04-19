<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/photos/{photo}/show', 'PhotoController@show')->name('photos.show');

Route::middleware(['auth'])->name('photos.')->group(function(){
    Route::post('/photos/{photo}/like', 'PhotoController@like')->name('like');
    Route::post('/photos/{photo}/comment', 'PhotoController@comment')->name('comment');
    Route::get('/photos/{photo}/edit', 'PhotoController@edit')->name('edit');
    Route::patch('/photos/{photo}/update', 'PhotoController@update')->name('update');
    Route::delete('/photos/{photo}/delete', 'PhotoController@delete')->name('delete');
    Route::get('/photos/upload', 'PhotoController@create')->name('upload');
    Route::post('/photos/upload', 'PhotoController@store')->name('upload.post');
    Route::get('/photos/self', 'PhotoController@self')->name('self');
});