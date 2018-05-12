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

Route::get('/documentation/create/title', function () {
    return view('/pages/documentationTitle');
})->name('documentationTitle');

Route::get('/documentation/create/subtitle', function () {
    return view('/pages/documentationSubtitle');
})->name('documentationSubtitle');

Route::get('/documentation/create/content', function () {
    return view('/pages/documentationContent');
})->name('documentationContent');

Route::group(['middleware' => ['auth', 'role:admin']], function(){

	Route::get('/', 'HomeController@index')->name('dashboard');

	Route::prefix('category')->group(function(){

		Route::get('/genre/adminGet', [
			'uses' => 'CategoryController@adminGetGenre',
		])->name('categoryGenre');

		Route::get('/type/adminGet', [
			'uses' => 'CategoryController@adminGetType',
		])->name('categoryType');

		Route::post('/genre/adminUpdate/{id}', [
			'uses' => 'CategoryController@adminUpdateGenre',
		])->name('editGenre');

		Route::post('/type/adminUpdate/{id}', [
			'uses' => 'CategoryController@adminUpdateType',
		])->name('editType');

		Route::post('/genre/adminDelete/{id}', [
			'uses' => 'CategoryController@adminDeleteGenre',
		])->name('deleteGenre');

		Route::post('/type/adminDelete/{id}', [
			'uses' => 'CategoryController@adminDeleteType',
		])->name('deleteType');

		Route::post('/genre/create', [
			'uses' => 'CategoryController@createGenre',
		])->name('addGenre');

		Route::post('/type/create', [
			'uses' => 'CategoryController@createType',
		])->name('addType');
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
		Route::get('/dashboard', function () {
		    return view('/pages/blogDashboard');
		})->name('blogDashboard');

		Route::get('/create', function () {
		    return view('/pages/blogCreate');
		})->name('blogCreate');

		Route::post('/createBlog', [
			'uses' => 'BlogController@createBlog',
		])->name('createPost');
		
		Route::get('/getPublishedBlog', [
			'uses' => 'BlogController@getPublishedBlogAdmin',
		])->name('getPusblisedPost');

		Route::get('/getUnpublishBlog', [
			'uses' => 'BlogController@getUnpublishBlog',
		])->name('getUnpublishPost');

		Route::post('/updateBlog/{id}',[
			'uses' => 'BlogController@updateBlog',
		])->name('updatePost');

		Route::post('/deleteBlog/{id}',[
			'uses' => 'BlogController@deleteBlog',
		])->name('deletePost');
	});

	Route::prefix('report')->group(function(){
		Route::get('/user/getReport', [
			'uses' => 'UserReportController@getReport',
		])->name('userReport');

		Route::post('/user/ban/{id}', [
			'uses' => 'UserReportController@banUser',
		])->name('userBan');

		Route::post('/user/unban/{id}', [
			'uses' => 'UserReportController@unbanUser',
		])->name('userUnban');

		Route::get('/story/getReport', [
			'uses' => 'StoryReportController@getReport',
		])->name('storyReport');

		Route::post('/story/ban/{id}', [
			'uses' => 'StoryReportController@banStory',
		])->name('storyBan');

		Route::post('/story/unban/{id}', [
			'uses' => 'StoryReportController@unbanStory',
		])->name('storyUnban');
	});

	Route::prefix('user')->group(function(){
		Route::get('/list',[
			'uses' => 'UserController@userList'
		])->name('userList');

		Route::get('/add', function () {
		    return view('/pages/userAdd');
		})->name('userAdd');

		Route::post('/addAdmin',[
			'uses' => 'UserController@addAdmin'
		])->name('addAdmin');
	});

	Route::get('/story/list',[
		'uses' => 'StoryController@storyList'
	])->name('storyList');
});