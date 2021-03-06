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

Route::post('/signup', [
	'uses' => 'UserController@signup'
]);

Route::post('/login', [
	'uses' => 'UserController@login',
]);

Route::post('/password/email', [
	'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmailAPI'
]);

Route::get('/password/reset/{token}', [
	'uses' => 'Auth\ResetPasswordController@getToken'
])->name('password.resetAPI');

Route::post('/password/reset', [
	'uses' => 'Auth\ResetPasswordController@resetAPI'
]);

Route::prefix('user')->group(function(){
	Route::post('/uploadImage', [
		'uses' => 'UserController@uploadImage',
		'middleware' => 'auth.jwt'
	]);

	Route::get('/getUser', [
		'uses' => 'UserController@getUser',
		'middleware' => 'auth.jwt'
	]);

	Route::post('/changePassword', [
		'uses' => 'UserController@changePassword',
		'middleware' => 'auth.jwt'
	]);

	Route::get('/history', [
		'uses' => 'UserController@history',
		'middleware' => 'auth.jwt'
	]);
});

Route::get('/category/genre/get', [
	'uses' => 'CategoryController@getGenre'
]);

Route::prefix('story')->group(function(){
	Route::post('/create',[
		'uses' => 'StoryController@createStory',
		'middleware' => 'auth.jwt'
	]);

	Route::get('/getMostPopular', [
		'uses' => 'StoryController@getMostPopular'
	]);
	
	Route::get('/getNewAvailable', [
		'uses' => 'StoryController@getNewAvailable'
	]);
	
	Route::get('/getUserBased', [
		'uses' => 'StoryController@getUserBased',
		'middleware' => 'auth.jwt'
	]);
	
	Route::get('/getItemBased/{storyId}', [
		'uses' => 'StoryController@getItemBased'
	]);
	
	
	Route::get('/search/{name?}',[
		'uses' => 'StoryController@searchStory',
	]);

	Route::get('/getStoryList', [
		'uses' => 'StoryController@getStoryList',
	]);

	Route::get('/getStory/{id}',[
		'uses' => 'StoryController@getStory',
	]);

	Route::get('/playStory/{id}',[
		'uses' => 'StoryController@playStory',
	]);

	Route::get('/addPlayed/{id}', [
		'uses' => 'StoryController@addPlayed'
	]);

	Route::post('/addReviewStory/{id}',[
		'uses' => 'StoryController@addReviewStory',
		'middleware' => 'auth.jwt'
	]);

	Route::post('/createComment/{sid}/{cpid?}', [
		'uses' => 'StoryController@createComment',
		'middleware' => 'auth.jwt'
	]);

	Route::prefix('writer')->group(function(){
		Route::get('/getStoryList',[
			'uses' => 'StoryController@writerGetStoryList',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/search/{name?}',[
			'uses' => 'StoryController@writerSearchStory',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/getStory/{id}',[
			'uses' => 'StoryController@writerGetStory',
			'middleware' => 'auth.jwt'
		]);

		Route::post('/update/{id}',[
			'uses' => 'StoryController@writerUpdateStory',
			'middleware' => 'auth.jwt'
		]);

		Route::post('/publish/{id}',[
			'uses' => 'StoryController@writerPublishedStory',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/unpublish/{id}',[
			'uses' => 'StoryController@writerUnpublishedStory',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/delete/{id}',[
			'uses' => 'StoryController@writerDeleteStory',
			'middleware' => 'auth.jwt'
		]);
	});
});

Route::get('/docs/getTableOfContent', [
	'uses' => 'DocController@getTableOfContent',
]);

Route::prefix('blog')->group(function(){
	Route::get('/getPublishedBlog', [
		'uses' => 'BlogController@getPublishedBlog',
	]);

	Route::get('/getPost/{id}', [
		'uses' => 'BlogController@getPost'
	]);

	Route::post('/createComment/{bid}/{cpid?}', [
		'uses' => 'BlogController@createComment',
		'middleware' => 'auth.jwt'
	]);
});

Route::prefix('report')->group(function(){
	Route::post('/user/{id}/{type}', [
		'uses' => 'UserReportController@reportUser',
		'middleware' => 'auth.jwt'
	]);

	Route::post('/story/{id}', [
		'uses' => 'StoryReportController@reportStory',
		'middleware' => 'auth.jwt' 
	]);
});