<?php

use App\Http\Middleware\CheckRegCompleteness;
use App\Http\Middleware\DisabledUsersFilter;
use App\Http\Middleware\NormalUsersFilter;

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
    /**
     * Not logged in user requests
     */
    Route::get('/categories', 'CategoriesController@index');
    Route::get('/category/{category}', 'CategoriesController@show');
    Route::group(['prefix' => 'events'], function() {
        Route::get('/', 'EventsController@index');
        Route::get('/proposals/{id}', 'EventsController@proposals');
        Route::get('/details/{proposal}', 'EventsController@details');
        Route::get('/general/{proposal}', 'EventsController@general');
        Route::get('/autocomplete', 'EventsController@autocomplete');
    });
    Route::group(['prefix' => 'auth'], function() {
        Route::post('/login', 'AuthController@login')->name('auth_login');
        Route::get('/refresh-token', 'AuthController@refreshToken');
        Route::post('/user-validation', 'AuthController@userValidation');
        Route::post('/registration', 'AuthController@registration')->name('auth_registration');
        Route::post('/forgot-password', 'AuthController@forgotPassword');
        Route::group(['middleware' => ['jwt.auth',]], function () {
            Route::get('/user', 'AuthController@getAuthenticatedUser')->name('auth_getAuthenticatedUser');
            Route::resource('user', 'UserController', ['only' => [
                'show', 'update', 'destroy'
            ]]);
        });
        Route::group(['middleware' => ['web']], function() {
            Route::post('/{provider}', 'AuthController@social');
            Route::get('/{provider}', 'AuthController@redirectToProvider');
        });
    });
    
    
    /**
     * Need authorization to perform a request
     */
    Route::group(['middleware' => ['jwt.auth']], function() {
        Route::group(['prefix' => 'user'], function() {
            Route::post('/progress/{progress}', 'UserController@updateProgress');
            Route::post('/profile-photo', 'UserController@profilePhoto');
            Route::get('/{user}/info', 'UserController@profileInfo');
        });
        Route::group(['middleware' => CheckRegCompleteness::class], function() {
            Route::group(['prefix' => 'events'], function() {
                /** Get current logged in user event requests */
                Route::get('/requests', 'EventsController@showUserRequests');
                
                /** Make event request to the user proposal */
                Route::group(['middleware' => NormalUsersFilter::class], function() {
                    Route::post('/requests/{proposal}', 'EventsController@storeRequest');
                });
                
                /** Add new event */
                Route::group(['middleware' => DisabledUsersFilter::class], function() {
                    /** Event add validation URLs */
                    Route::post('/add/general', 'EventAddController@general');
                    Route::post('/add/category', 'EventAddController@category');
                    Route::post('/add/date-place', 'EventAddController@datePlace');
                    Route::post('/add/tickets', 'EventAddController@tickets');
                    Route::post('/add', 'EventAddController@add');
                    
                    /** Accept event request */
                    Route::post('/requests/{requestId}/accept', 'EventsController@eventAccept');

                    /** Decline event request */
                    Route::post('/requests/{requestId}/reject', 'EventsController@eventReject');
                    
                    /** Show event request details */
                    Route::get('/requests/{requestId}/overview', 'EventsController@requestOverview');
                });
                
                /** Get upcoming (future) events list */
                Route::get('/upcoming', 'EventsController@upcomingEvents');
            });
            Route::get('/check/restricted', 'CheckController@restricted');
            Route::get('/faq', 'FAQController@index');
            Route::post('/testimonial', 'TestimonialController@store');
        });
    });
});

