<?php

use Illuminate\Support\Facades\Route;

// all routes here is related to the dashboard or the admins only [permissions & groups & authentication & admins & profile & dashboard home & translations]
$attributes=['prefix' => LaravelLocalization::setLocale(),'middleware' => macameraMiddlewares()];
// apply some middleware to make the system support multi languages
Route::group($attributes, function(){
    Route::group(['prefix' => config('general.routes.backend.prefix')],function () {
        // all routes here required the admin to be authenticated
        Route::group(['middleware' => 'backendGate:backend,auth'], function () {
            // start blog routes
            Route::group(['prefix'=>'Blog','namespace'=>'Blog'],function (){
                // start post routes
                Route::resource('Post','PostController')->except('show');
                Route::get('Post/{Post}/status','PostController@status')->name('Post.status');
                Route::get('Post/trashed','PostController@trashed')->name('Post.trashed');
                Route::post('Post/{Post}/restore','PostController@restore')->name('Post.restore');
                Route::delete('Post/{Post}/force-delete','PostController@forceDelete')->name('Post.force-delete');
                // start category routes
                Route::resource('Category','CategoryController');
                // start tag routes
                Route::resource('Tag','TagController');
            });
        });
    });
});


