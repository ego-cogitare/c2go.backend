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
    Route::group(['prefix' => 'events'], function() {
        Route::get('/', 'EventsController@index');
        Route::get('/proposals/{id}', 'EventsController@proposals');
        Route::get('/details/{event}/user/{user}', 'EventsController@details');
        Route::get('/general/{event}/user/{user}', 'EventsController@general');
    });
    
    Route::get('/categories', 'CategoriesController@index');
    Route::get('/category/{category}', 'CategoriesController@show');
    
    Route::group(['prefix' => 'auth'], function() {
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
        Route::group(['middleware' => ['web']], function() {
            Route::post('/{provider}', 'AuthController@social');
            Route::get('/{provider}', 'AuthController@redirectToProvider');
        });
    });
    
    Route::group(['middleware' => ['jwt.auth']], function() {
        Route::group(['prefix' => 'user'], function() {
            Route::post('/progress/{progress}', 'UserController@updateProgress');
            Route::post('/profile-photo', 'UserController@profilePhoto');
            Route::get('/{user}/info', 'UserController@profileInfo');
        });
        Route::group(['middleware' => CheckRegCompleteness::class], function() {
            Route::group(['prefix' => 'events'], function() {
                // Get curent logged in user event requests
                Route::get('/requests', 'EventsController@showUserRequests');
                
                // Make event {event} request to the user {user}
                Route::post('/requests/{event}/user/{user}', 'EventsController@storeRequest');
                
                // Show details
                Route::get('/accept/{event}', 'EventsController@showEventAccept');
            });
            Route::get('/check/restricted', 'CheckController@restricted');
            Route::get('/faq', 'FAQController@index');
            Route::post('/testimonial', 'TestimonialController@store');
        });
    });
});

