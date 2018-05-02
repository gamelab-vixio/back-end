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

Route::post('/login', [
	'uses' => 'UserController@login'
]);

Route::post('/signup', [
	'uses' => 'UserController@signup'
]);

Route::prefix('user')->group(function(){
	Route::post('/uploadImage', [
		'uses' => 'userController@uploadImage',
		'middleware' => 'auth.jwt'
	]);
	Route::get('/loadImage', [
		'uses' => 'userController@loadImage',
		'middleware' => 'auth.jwt'
	]);

	Route::get('/getUser', [
		'uses' => 'userController@getUser',
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

	Route::get('/getStoryList', [
		'uses' => 'StoryController@getStoryList',
	]);

	Route::get('/getStory/{id}',[
		'uses' => 'StoryController@getStory',
	]);

	Route::get('/playStory/{id}',[
		'uses' => 'StoryController@playStory',
	]);

	Route::prefix('writer')->group(function(){
		Route::get('/getStoryList',[
			'uses' => 'StoryController@writerGetStoryList',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/getStory/{id}',[
			'uses' => 'StoryController@writerGetStory',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/getContent/{id}',[
			'uses' => 'StoryController@writerGetContent',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/getCategoryList',[
			'uses' => 'StoryController@writerGetCategoryList',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/loadImage/{id}',[
			'uses' => 'StoryController@writerLoadImage',
			'middleware' => 'auth.jwt'
		]);

		Route::post('/update/{id}',[
			'uses' => 'StoryController@writerUpdateStory',
			'middleware' => 'auth.jwt'
		]);

		Route::get('/publish/{id}',[
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
	Route::post('/addReviewStory/{id}',[
		'uses' => 'StoryController@addReviewStory',
		'middleware' => 'auth.jwt'
	]);

	Route::post('/createComment/{bid}/{cpid?}', [
		'uses' => 'StoryController@createComment',
		'middleware' => 'auth.jwt'
	]);
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

	Route::get('/loadImage/{id}', [
		'uses' => 'BlogController@loadImage',
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

//admin
Route::prefix('category')->group(function(){
	Route::get('/genre/adminGet', [
		'uses' => 'CategoryController@adminGetGenre'
	]);

	Route::get('/type/adminGet', [
		'uses' => 'CategoryController@adminGetType'
	]);

	Route::post('/genre/adminUpdate/{id}', [
		'uses' => 'CategoryController@adminUpdateGenre'
	]);

	Route::post('/type/adminUpdate/{id}', [
		'uses' => 'CategoryController@adminUpdateType'
	]);

	Route::get('/genre/adminDelete/{id}', [
		'uses' => 'CategoryController@adminDeleteGenre'
	]);

	Route::get('/type/adminDelete/{id}', [
		'uses' => 'CategoryController@adminDeleteType'
	]);

	Route::post('/genre/create', [
		'uses' => 'CategoryController@createGenre',
	]);

	Route::post('/type/create', [
		'uses' => 'CategoryController@createType',
	]);
});

Route::prefix('docs')->group(function(){
	Route::get('/adminGet',[
		'uses' => 'DocController@adminGetAll'
	]);

	Route::post('/createTitle', [
		'uses' => 'DocController@createTitle',
	]);

	Route::post('/createSubtitle', [
		'uses' => 'DocController@createSubtitle',
	]);

	Route::post('/createContent', [
		'uses' => 'DocController@createContent',
	]);

	Route::get('/adminGetTitle', [
		'uses' => 'DocController@adminGetTitle',
	]);

	Route::post('/adminUpdate/{tid}/{sid?}/{hid?}', [
		'uses' => 'DocController@adminUpdate',
	]);

	Route::get('/adminDelete/{tid}/{sid?}/{hid?}', [
		'uses' => 'DocController@adminDelete',
	]);
});

Route::prefix('blog')->group(function(){
	Route::post('/createBlog', [
		'uses' => 'BlogController@createBlog',
		'middleware' => 'auth.jwt'
	]);

	Route::get('/getUnpublishedBlog', [
		'uses' => 'BlogController@getUnpublishedBlog',
	]);

	Route::post('/updateBlog/{id}',[
		'uses' => 'BlogController@updateBlog',
	]);

	Route::get('/deleteBlog/{id}',[
		'uses' => 'BlogController@deleteBlog',
	]);
});

Route::prefix('report')->group(function(){
	Route::get('/user/getReport', [
		'uses' => 'UserReportController@getReport',
	]);

	Route::get('/user/ban/{id}', [
		'uses' => 'UserReportController@banUser',
	]);

	Route::get('/user/unban/{id}', [
		'uses' => 'UserReportController@unbanUser',
	]);

	Route::get('/story/getReport', [
		'uses' => 'StoryReportController@getReport',
	]);

	Route::get('/story/ban/{id}', [
		'uses' => 'StoryReportController@banStory',
	]);

	Route::get('/story/unban/{id}', [
		'uses' => 'StoryReportController@unbanStory',
	]);
});