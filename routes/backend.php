<?php

// all routes here is related to the dashboard or the admins only
$languageMiddleware= [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ];
$attributes=['prefix' => LaravelLocalization::setLocale(),'middleware' => $languageMiddleware];
// apply some middleware to make the system support multi languages
Route::group($attributes, function(){

    Route::group(['prefix' => config('general.routes.backend.prefix')],function (){
        // all routes here not required the admin to be authenticated
        Route::group(['middleware'=>'backendGate:backend,guest'],function(){
            // show login form and login
          Route::group(['namespace' => 'Auth'],function (){
              Route::get('/Login','AdminAuthController@showLoginForm')->name('dashboard.login.show');
              Route::post('/Login','AdminAuthController@login')->name('dashboard.login');
          });
        });

        // all routes here required the admin to be authenticated
        Route::group(['middleware'=>'backendGate:backend,auth'],function(){
            // logout or terminate the admin session
            Route::group(['namespace' => 'Auth'],function (){
                Route::post('/Logout','AdminAuthController@logout')->name('dashboard.logout');
            });

            // show the current authenticated user account info and update the information
            Route::group(['namespace' => 'Auth'],function (){
                Route::get('/My-Account','AdminAccountController@showAccount')->name('dashboard.account.show');
                Route::put('/Update-Account-Info','DashboardController@updateInformation')->name('dashboard.account.update');
                Route::put('/Reset-Account-Password','DashboardController@resetPassword')->name('dashboard.account.reset');
            });


            // show the home page of the dashboard
            Route::group(['namespace' => 'Home'],function (){
                Route::get('/','DashboardController@index')->name('dashboard.index');
                Route::get('/Home','DashboardController@index')->name('dashboard.index');
                Route::get('/Dashboard','DashboardController@index')->name('dashboard.index');
            });

            // manage the groups and permissions
            Route::group(['namespace' => 'Group','prefix'=>'Group'],function (){
                Route::get('/index','GroupController@index')->name('group.index');
                Route::get('/create','GroupController@create')->name('group.create');
                Route::post('/store','GroupController@store')->name('group.store');
                Route::get('/edit/{name}','GroupController@edit')->name('group.edit');
                Route::put('/update/{name}','GroupController@update')->name('group.update');
                Route::delete('/destroy/{name}','GroupController@destroy')->name('group.destroy');
                
            });

        });

    });
});
