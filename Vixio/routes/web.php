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

Auth::routes();

// TEST ROUTES
Route::get('/blog/dashboard', function () {
    return view('/pages/blogDashboard');
})->name('blogDashboard');

Route::get('/blog/create', function () {
    return view('/pages/blogCreate');
})->name('blogCreate');

Route::get('/documentation/create/title', function () {
    return view('/pages/documentationTitle');
})->name('documentationTitle');

Route::get('/documentation/create/subtitle', function () {
    return view('/pages/documentationSubtitle');
})->name('documentationSubtitle');

Route::group(['middleware' => ['auth', 'role:admin']], function(){

	Route::get('/', 'HomeController@index')->name('dashboard');

	Route::prefix('category')->group(function(){
		Route::get('/genre/adminGet', [
			'uses' => 'CategoryController@adminGetGenre',
		]);

		Route::get('/type/adminGet', [
			'uses' => 'CategoryController@adminGetType',
		]);

		Route::post('/genre/adminUpdate/{id}', [
			'uses' => 'CategoryController@adminUpdateGenre',
		]);

		Route::post('/type/adminUpdate/{id}', [
			'uses' => 'CategoryController@adminUpdateType',
		]);

		Route::get('/genre/adminDelete/{id}', [
			'uses' => 'CategoryController@adminDeleteGenre',
		]);

		Route::get('/type/adminDelete/{id}', [
			'uses' => 'CategoryController@adminDeleteType',
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
			'uses' => 'DocController@adminGetAll',
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

		Route::get('/adminGetSubtitle', [
			'uses' => 'DocController@adminGetSubtitle',
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
		]);

		Route::get('/getPublishedBlog', [
			'uses' => 'BlogController@getPublishedBlog',
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

	Route::prefix('user')->group(function(){
		Route::get('/userList',[
			'uses' => 'UserController@userList'
		]);

		Route::post('/addAdmin',[
			'uses' => 'UserController@addAdmin'
		]);
	});

	Route::get('/story/storyList',[
		'uses' => 'StoryController@storyList'
	]);
});