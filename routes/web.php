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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//users
Route::get('/logout', 'UserController@logout')->name('logout');
Route::get('/login', 'UserController@login')->name('login');
Route::get('/register', 'UserController@register')->name('register');
Route::get('/{username}', 'UserController@profile')->name('profile');

//stories
Route::get('/{username}/stories', 'StoryController@stories')->name('stories');
Route::get('/{username}/{story}', 'StoryController@profile')->name('story');
Route::get('/{username}/{story}/{id}', 'StoryController@profile')->name('storyDetail');
Route::put('/story', 'StoryController@putStory');
Route::patch('/story', 'StoryController@patchStory');
Route::delete('/story', 'StoryController@deleteStory');

//subscriptions
Route::put('/subscription/{storyId}', 'SubscriptionController@putSubscription');
Route::get('/subscriptions', 'SubscriptionController@getSubscriptions');