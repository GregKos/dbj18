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
// App Routes
Route::get('/', 'IndexController@index')->name('siteindex');
// Post Routes
Route::resource('posts', 'PostController');
Route::post('/posts/toggle/{id}/{target_state}', 'PostController@togglePublished')->name('posts.toggle');
Route::post('/posts/upload', 'PostController@handleUpload')->name('posts.upload');
Route::delete('/posts/upload/{path}', 'PostController@deleteUpload')->name('posts.deleteupload');
// Category Routes
Route::resource('categories', 'CategoryController');