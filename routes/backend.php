<?php
use Illuminate\Support\Facades\Route;

/* Routes For System Base */

// all routes here is related to the dashboard or the admins only [permissions & groups & authentication & admins & profile & dashboard home & translations]
$attributes=['prefix' => LaravelLocalization::setLocale(),'middleware' => macameraMiddlewares()];
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
                Route::any('/Logout','AdminAuthController@logout')->name('dashboard.logout');
                Route::get('/Permissions','AdminAuthController@refreshPermissions')->name('dashboard.permissions.refresh');
            });

            // show the current authenticated user account info and update the information
            Route::group(['namespace' => 'Auth'],function (){
                Route::get('/My-Account','AdminAccountController@showAccount')->name('dashboard.account.show');
                Route::put('/Update-Account-Info','AdminAccountController@updateInformation')->name('dashboard.account.update');
                Route::put('/Reset-Account-Password','AdminAccountController@resetPassword')->name('dashboard.account.reset');
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

           // manage the admins
           Route::group(['namespace' => 'Admin'],function (){
                Route::resource('/Admin','AdminController')->except('show');
            });

            // manage the translations
            Route::group(['namespace' => 'Setting'],function (){
                Route::get('/Setting','SettingController@index')->name('setting.index');
                Route::get('/Translation','TranslationController@index')->name('translation.index');
                Route::post('/Translation','TranslationController@save')->name('translation.save');
            });

            Route::group(['prefix' => 'FileManager'], function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
            });

        });

    });
});



/* Routes For System Logic */
require_once 'backend-business-logic.php';
