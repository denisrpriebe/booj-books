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

Route::redirect('/', 'books');

// Pages
Route::get('books', 'PageController@books');
Route::get('list', 'PageController@list');

// API Routes
Route::get('api/books', 'BookController@index');
Route::get('api/books/{olid}', 'BookController@show');

Route::get('api/list', 'ListController@index');
Route::post('api/list', 'ListController@store');
Route::put('api/list/{book}', 'ListController@update');
Route::delete('api/list/{book}', 'ListController@destroy');
