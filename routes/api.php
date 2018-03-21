<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@login')->name('auth_login');
        Route::post('/user-validation', 'AuthController@userValidation');
        Route::post('/registration', 'AuthController@registration')->name('auth_registration');
        Route::post('/forgot_password', 'AuthController@forgotPassword');
        Route::group(['middleware' => ['jwt.auth',]], function () {
            Route::get('/user', 'AuthController@getAuthenticatedUser')->name('auth_getAuthenticatedUser');
            Route::get('/token', 'AuthController@refreshToken');
            Route::resource('user', 'UserController', ['only' => [
                'show', 'update', 'destroy'
            ]]);
        });
        Route::group(['middleware' => ['web']], function () {
            Route::post('/{provider}', 'AuthController@social');
            Route::get('/{provider}', 'AuthController@redirectToProvider');
        });
    });
    
    Route::group(['middleware' => ['jwt.auth',]], function () {
        Route::get('/check/restricted', 'CheckController@restricted');
        
        Route::get('/faq', 'FAQController@index');
        Route::post('/testimonial', 'TestimonialController@store');
        
        Route::group(['prefix' => 'user'], function () {
            Route::group(['prefix' => 'settings'], function () { 
                Route::get('/', 'SettingsController@show');
                Route::get('/{section}', 'SettingsController@showSection');
                Route::get('/key/{key}', 'SettingsController@showByKey');
                Route::post('/', 'SettingsController@store');
                Route::put('/{id}', 'SettingsController@update');
                Route::delete('/{id}', 'SettingsController@destroy');
            });
            Route::get('/profile/{id}', 'UserController@publicProfile');
            Route::resource('answer', 'AnswerController', ['only' => [
                'index', 'show', 'store',
            ]]);
        });
    });

});

