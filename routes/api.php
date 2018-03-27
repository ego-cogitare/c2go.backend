<?php

use App\Http\Middleware\CheckRegCompleteness;

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
    
    Route::get('/events', 'EventsController@index');
    Route::get('/categories', 'CategoriesController@index');
    
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
    
    Route::group(['middleware' => ['jwt.auth']], function() {
        Route::group(['prefix' => 'user'], function () {
            Route::post('/progress/{progress}', 'UserController@updateProgress');
            Route::post('/profile-photo', 'UserController@profilePhoto');
        });
        Route::group(['middleware' => CheckRegCompleteness::class], function() {
            Route::get('/dashboard', 'DashboardController@index');
            Route::get('/check/restricted', 'CheckController@restricted');
            Route::get('/faq', 'FAQController@index');
            Route::post('/testimonial', 'TestimonialController@store');
        });
    });
});

