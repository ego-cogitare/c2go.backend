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
        Route::post('/registration', 'AuthController@registration')->name('auth_registration');
        Route::post('/forgot_password', 'AuthController@forgotPassword');
        Route::group(['middleware' => ['jwt.auth',]], function () {
            Route::get('/user', 'AuthController@getAuthenticatedUser')->name('auth_getAuthenticatedUser');
            Route::get('/token', 'AuthController@refreshToken');
            //Route::get('/user/block/{id}', 'UserController@block');
            Route::resource('user', 'UserController', ['only' => [
                'show', 'update', 'destroy'
            ]]);
        });
        Route::post('/{provider}', 'AuthController@social');
    });
    
    Route::get('/podcast', 'PodcastController@index');

    Route::group(['middleware' => ['jwt.auth',]], function () {
        Route::get('/check/restricted', 'CheckController@restricted');
        
        Route::group(['prefix' => 'podcast'], function () {
            Route::get('/{id}', 'PodcastController@show');
            Route::get('/{id}/categories', 'PodcastController@categories');
            Route::get('/{id}/criterias', 'PodcastController@criterias');
        });
        
        Route::group(['prefix' => 'category'], function () {
            Route::get('/{id}', 'CategoryController@show');
        });
        
        Route::group(['prefix' => 'question'], function () {
            Route::get('/{id}', 'QuestionController@show');
            Route::put('/{id}/privacy', 'QuestionController@privacyUpdate');
        });
        
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
        
        /**
         * Example of restricted rules
         */
        /*
        Route::get('/broker/invite/{id}', 'BrokerController@invite');

        Route::get('/broker/{id}/cars', 'BrokerController@cars');
        Route::resource('broker', 'BrokerController', ['only' => [
            'index', 'store'
        ]]);
        */
    });

});

