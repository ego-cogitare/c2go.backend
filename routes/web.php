<?php

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
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/check', 'HomeController@check')->name('home_check');
Route::get('/home/test', 'HomeController@test')->name('home_test');

/**
 * Do not remove!
 * Routes for questionnaire builder development. 
 */
//Route::group(['prefix' => 'admin/podcast', 'namespace' => 'Admin'], function () {
//    Route::get('/', 'PodcastController@index');
//    Route::get('/{id}', 'PodcastController@show');
//    Route::put('/{id}', 'PodcastController@update');
//    Route::delete('/{id}', 'PodcastController@remove');
//});
//Route::group(['prefix' => 'admin/file', 'namespace' => 'Admin'], function () {
//    Route::post('/upload', 'FileController@upload');
//});
//Route::group(['prefix' => 'admin/question', 'namespace' => 'Admin'], function () {
//    Route::get('/', 'QuestionController@index');
//});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/login', 'AuthController@showLoginForm')->name('admin.login');
        Route::post('/login', 'AuthController@login')->name('admin.login.submit');
    });
    Route::group(['middleware'=>'auth:admin'], function () {
        Route::get('/logout', function() {
            Auth::logout();
            return redirect()->intended(route('admin.login'));
        });
        
        Route::post('/file/upload', 'FileController@upload')->name('admin.file.upload');
        
        Route::group(['prefix' => 'podcast'], function () {
            Route::get('/', 'PodcastController@index');
            Route::get('/{id}', 'PodcastController@show');
            Route::put('/{id}', 'PodcastController@update');
            Route::delete('/{id}', 'PodcastController@remove');
        });
        
        Route::group(['prefix' => 'category'], function () {
            Route::delete('/{id}', 'CategoryController@remove');
        });
        
        Route::group(['prefix' => 'question'], function () {
            Route::get('/', 'QuestionController@index');
        });
        
        Route::get('/', 'IndexController@index')->name('admin.dashboard');
        Route::get('/report/{type}', 'ReportController@index');
        Route::resource('/pages', 'PagesController');
        Route::resource('/admins', 'AdminsController');
        Route::resource('/users', 'UsersController');
        Route::resource('/faqs', 'FAQsController');
        Route::resource('/testimonials', 'TestimonialsController');
        
        Route::group(['prefix' => 'questionnaire'], function () {
            Route::get('/category', 'QuestionnairesController@category');
            Route::get('/cryteria', 'QuestionnairesController@cryteria');
        });
    });
});