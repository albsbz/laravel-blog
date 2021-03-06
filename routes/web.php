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

Route::get('/', 'HomeController@index')->name('index');
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');
Route::get('/tag/{slug}', 'HomeController@tag')->name('tag.show');
Route::get('/category/{slug}', 'HomeController@category')->name('category.show');
Route::post('/subscribe', 'SubController@subscribe');
Route::get('/verify/{token}', 'SubController@verify')->name('sub.verify');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::post('/profile', 'ProfileController@store');
    Route::post('/comment', 'CommentsController@store');
});
Route::group(['middleware'=>'guest'], function(){
    Route::get('/register', 'AuthController@registerForm')->name('register');
    Route::post('/register', 'AuthController@register');
    Route::get('/login', 'AuthController@loginForm')->name('login');
    Route::post('/login', 'AuthController@login');
   
});


Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>'admin'], function(){
    Route::get('/', 'DashboardController@index');
    Route::resource('/categories','CategoriesController');
    Route::resource('/tags','TagsController');
    Route::resource('/users','UsersController');
    Route::resource('/posts','PostsController');
    Route::get('/comments', 'CommentsController@index')->name('comments.index');
    Route::delete('/comments/{id}/destroy', 'CommentsController@destroy')->name('comments.destroy');
    Route::get('/comments/toggle/{id}', 'CommentsController@toggle');
    Route::resource('/subs', 'SubController');
});
