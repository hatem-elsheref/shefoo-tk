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

Route::get('/', function () {

    return view('backend.auth.login');
//    return view('welcome');
})->name('statistics');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');






// used in dashboard in category and tags
Route::get('/tag/{slug}',function (){
    return 'all posts of this tag by slug';
})->name('blog.searchByTag');

Route::get('/category/{slug}',function (){
    return 'all posts of this category by slug';
})->name('blog.searchByCategory');
Route::get('/post/{slug}',function (){
    return 'show post details by slug';
})->name('blog.searchByPost');

