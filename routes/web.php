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

//marketing & generic
Route::get('/', 'ContentController@home')->name('home'); //done
Route::get('/imprint', 'ContentController@imprint')->name('imprint'); //done
Route::get('/privacy-policy', 'ContentController@privacyPolicy')->name('privacy-policy'); //done
Route::get('/about', 'ContentController@about')->name('about'); //done

//auth middleware: only authenticated users
Route::middleware('auth')->group(function () {

    //users auth
    Route::get('/logout', 'UserController@logout')->name('logout'); //done
    Route::patch('/user', 'UserController@patchUser')->name('patchUser'); //done
    Route::delete('/user', 'UserController@sendDeleteVerificationMail')->name('sendDeleteVerificationMail'); //done
    Route::get('/user/delete/{token}', 'UserController@deleteUser')->name('deleteUser'); //done
});

//users
Route::get('/login', 'UserController@login')->name('login'); //done
Route::put('/login', 'UserController@putLogin')->name('login'); //done
Route::get('/login/{token}', 'UserController@userLoginWithToken'); //done
Route::get('/{username}', 'UserController@profile')->name('profile'); //done

//stories
Route::get('/{username}/stories', 'StoryController@stories')->name('stories'); //done
Route::get('/{username}/{story}', 'StoryController@story')->name('story'); //done
Route::get('/{username}/{story}/{storyCounter}', 'StoryController@storyDetail')->name('storyDetail'); //done

//auth middleware: only authenticated users
Route::middleware('auth')->group(function () {

    //stories auth
    Route::put('/story', 'StoryController@putStory')->name('putStory'); //done
    Route::patch('/story', 'StoryController@patchStory')->name('patchStory'); //done
    Route::delete('/story', 'StoryController@deleteStory')->name('deleteStory'); //done

    //story details auth
    Route::put('/story-details', 'StoryDetailsController@putStoryDetails')->name('putStoryDetails');
    Route::patch('/story-details', 'StoryDetailsController@patchStoryDetails')->name('patchStoryDetails');
    Route::delete('/story-details', 'StoryDetailsController@deleteStoryDetails')->name('deleteStoryDetails');

    //subscriptions auth
    Route::put('/subscription/{storyId}', 'SubscriptionController@putSubscription');
    Route::get('/subscriptions', 'SubscriptionController@getSubscriptions');
});

