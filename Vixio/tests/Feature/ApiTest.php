<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use JWTAuth;
use App\User;
use Auth;
class ApiTest extends TestCase{

	// use RefreshDatabase;
	use DatabaseTransactions;

	protected $header;
	protected $token;

	public function setUp(){
		parent::setUp();

		$this->header = [
			'X-Requested-With' => 'XMLHttpRequest',
			'Content-Type' => 'application/json'
		];

		//change accordingly with the stories user_id
		$user = User::find(642);

		$this->token = JWTAuth::fromUser($user);
        
        JWTAuth::setToken($this->token);
        
	}

	/***************************** User (START) ************************************/

	/** @test */
	function sign_up_and_login(){
		//sign up
		$response = $this->withHeaders($this->header)->json('POST', 'api/signup',[
			'name' => 'testing test',
			'email' => 'test.testing@gmail.com',
			'password' => '123123'
		]);

		$response->assertStatus(201);

		//sign in
		$response = $this->withHeaders($this->header)->json('POST', '/api/login', [
			'email' => 'test.testing@gmail.com',
			'password' => '123123'
		]);

		$response->assertJsonStructure(['token']);

		$response->assertStatus(200);
	}

	function uploadImage(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/user/uploadImage/?token='.$this->token, [
			'photo' => UploadedFile::fake()->image('avatar.jpg')
		]);

		$response->assertStatus(201);
	}

	/** @test */
	function loadImage(){

		$response = $this->get('/api/user/loadImage/?token='.$this->token);

		$response->assertStatus(200);
	}

	/** @test */
	function changePassword(){

		$response = $response = $this->withHeaders($this->header)->json('POST', '/api/user/changePassword/?token='.$this->token, [
			'currentPassword' => "123123",
			'newPassword' => "321321",
			'newPassword_confirmation' => "321321"
		]);

		$response->assertJson([
			'message' => 'Successfully changed password'
		]);

		$response->assertStatus(200);
	}
	
	/** @test */
	function getUser(){

		$response = $this->get('/api/user/getUser/?token='.$this->token);

		$response->assertJsonStructure([
			'name',
			'email',
			'image_url'
		]);

		$response->assertStatus(201);
	}

	/** @test */
	function history(){
		$response = $this->get('/api/user/history/?token='.$this->token);

		$response->assertStatus(200);

	}

	/***************************** User (END) ************************************/

	/***************************** Category (START) ************************************/
	/** @test */
	function getGenre(){
		$response = $this->get('/api/category/genre/get');

		$response->assertJsonStructure([
			'*' => [
				'id',
				'genre',
				'category_type' => [
					'*'=>[
						'id',
						'genre_id',
						'name'
					]
				]
			]
		]);

		$response->assertStatus(200);
	}
	/***************************** Category (END) ************************************/

	/***************************** Story (START) ************************************/
	/** @test */
	function createStory(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/story/create/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => [2,3,4,7],
			'description' => 'testing purpose'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/create/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => [2,3,4,7],
			'description' => 'testing purpose',
			'image_url' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/create/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => [2,3,4,7],
			'description' => 'testing purpose',
			'image_url' => UploadedFile::fake()->image('avatar.jpg'),
			'content' => 'Quia impedit consequuntur id est eligendi. Porro soluta maiores reprehenderit hic minus enim expedita. Voluptate suscipit ducimus nihil.Rerum illum ullam quia ipsum ut. Quia nemo possimus ab blanditiis dolorum molestiae. Ratione sed totam quaerat asperiores. Est neque vel nesciunt architecto',
		]);

		$response->assertStatus(201);
	}

	/** @test */
	function getStoryList(){
		$response = $this->get('/api/story/getStoryList');

		$response->assertJsonStructure([
			'current_page', 'first_page_url','from', 'last_page','last_page_url','next_page_url','path','per_page','prev_page_url','to','total',
			'data' => [
				'*' => [
					'id','user_id','title','image_url','publish','active','year_of_release',
					'user' => ['id','name'],
					'story_category' => [
						'*' => [
								'story_id','category_type_id',
								'category_type' => ['id', 'name']
							]
					]
				]
			]
		]);

		$response->assertStatus(200);
	}

	/** @test */
	function get_story_using_id(){
		$response = $this->get('/api/story/getStory/1');

		$response->assertJsonStructure([
			'id','user_id','title','description','image_url','publish','active','year_of_release',
			'user' => ['id','name'],
			'story_category' => [
				'*' => [
						'story_id','category_type_id',
						'category_type' => ['id', 'name']
					]
			]
		]);

		$response->assertStatus(200);
	}

	/** @test */
	function play_story(){
		$response = $this->get('/api/story/playStory/1');

		$response->assertJsonStructure(['inkle']);

		$response->assertStatus(200);
	}

	/** @test */
	function writerStoryList(){
		$response = $this->get('/api/story/writer/getStoryList/?token='.$this->token);

		$response->assertJsonStructure([
			'current_page', 'first_page_url','from', 'last_page','last_page_url','next_page_url','path','per_page','prev_page_url','to','total',
			'data' => [
				'*' => [
					'id','user_id','title','image_url','publish','active','year_of_release','played',
					'story_category' => [
						'*' => [
								'story_id','category_type_id',
								'category_type' => ['id', 'name']
							]
					]
				]
			]
		]);

		$response->assertStatus(200);

	}

	/** @test */
	function writer_get_story_using_id(){
		$response = $this->get('/api/story/writer/getStory/1/?token='.$this->token);

		$response->assertJsonStructure([
			'id','user_id','title', 'description','image_url','publish','active','year_of_release','played',
			'story_category' => [
				'*' => [
						'story_id','category_type_id',
						'category_type' => ['id', 'name']
					]
			]
		]);

		$response->assertStatus(200);

	}

	/** @test */
	function writer_get_story_content_using_id(){
		$response = $this->get('/api/story/writer/getContent/1/?token='.$this->token);

		$response->assertJsonStructure(['user_id','content']);

		$response->assertStatus(200);
	}

	/** @test */
	function writer_get_category_list(){
		$response = $this->get('/api/story/writer/getCategoryList/?token='.$this->token);

		$response->assertJsonStructure([
			'*'=> ['id','genre_id','name']
		]);

		$response->assertStatus(200);
	}

	/** @test */
	function writer_story_load_image(){

		$response = $this->get('/api/story/writer/loadImage/1/?token='.$this->token);

		$response->assertStatus(200);
	}

	/** @test */
	function writer_story_update(){

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/writer/update/1/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => [2,3,4,7],
			'description' => 'testing purpose'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/writer/update/1/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => [2,3,4,7],
			'description' => 'testing purpose',
			'image_url' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertStatus(201);
	}

	//writer_story_publish will be tested in postman because i cannot find a way to test inklecate.exe in phpunit
	/** @test */
	function writer_story_unpublish(){
		$response = $this->get('/api/story/writer/unpublish/1/?token='.$this->token);

		$response->assertStatus(200);
	}

	/** @test */
	function writer_story_delete(){
		$response = $this->get('/api/story/writer/delete/1/?token='.$this->token);

		$response->assertStatus(200);
	}

	/** @test */
	function addReviewStory(){
		//change accorindgly to stories story_id
		$response = $this->withHeaders($this->header)->json('POST', '/api/story/addReviewStory/1/?token='.$this->token, [
			'star' => 4
		]);

		$response->assertStatus(200);

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/addReviewStory/1/?token='.$this->token, [
			'star' => 10
		]);

		$response->assertStatus(422);

	}

	/** @test */
	function story_comment(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/story/createComment/1/?token='.$this->token, [
			'comment' => 'hello there this is a test'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/createComment/1/1/?token='.$this->token, [
			'comment' => 'hello there this is a test'
		]);

		$response->assertStatus(201);
	}

	/** @test */
	function add_played(){
		$response = $this->get('/api/story/addPlayed/1');

		$response->assertStatus(200);

		$response = $this->get('/api/story/addPlayed/1?token='.$this->token);

		$response->assertStatus(200);
	}

	/***************************** Story (END) ************************************/

	/***************************** Documentation (START) ************************************/

	/** @test */
	function documentation_testing(){
		$response = $this->get('/api/docs/getTableOfContent');
		
		$response->assertJsonStructure([
			'*' => [
				'id',
				'title',
				'subtitle' => [
					'*' => [
						'id','title_id','subtitle',
						'content' => [
							'*' => [
								'subtitle_id','header','content'
							]
						]
					]
				]
			]
		]);

		$response->assertStatus(200);
	}

	/***************************** Documentation (END) ************************************/

	/***************************** Blog (START) ************************************/

	/** @test */
	function getPublishedBlog(){
		$response = $this->get('/api/blog/getPublishedBlog');
		
		$response->assertJsonStructure([
			'*' => [
				'id',
				'title',
				'content',
				'image_url',
				'status',
				'updated_at'
			]
		]);

		$response->assertStatus(200);
	}

	/** @test */
	function get_post_by_id(){
		$response = $this->get('/api/blog/getPost/1');

		$response->assertJsonStructure([
			'id',
			'title',
			'content',
			'image_url',
			'status',
			'updated_at',
			'blog_comment' => [
				'*' => ['id','blog_id','user_id','comment','comment_parent_id','created_at',
					'user' => ['id','name','email','image_url'],
					'reply' => [
						'*' => ['blog_id','user_id','comment','comment_parent_id','created_at',
							'user' => ['id','name','email','image_url']
						]
					]
				]
			]
		]);

		$response->assertStatus(200);
	}

	/** @test */
	function blog_load_image(){
		$response = $this->get('/api/blog/loadImage/1');

		$response->assertStatus(200);
	}

	/** @test */
	function blog_comment(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/blog/createComment/1/?token='.$this->token, [
			'comment' => 'hello there this is a test'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/blog/createComment/1/1/?token='.$this->token, [
			'comment' => 'hello there this is a test'
		]);

		$response->assertStatus(201);
	}

	/***************************** Blog (END) ************************************/

	/***************************** Report (START) ************************************/

	/** @test */
	function reportUser(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/report/user/1/0/?token='.$this->token, [
			'reason' => 'hello there, this is a test'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/report/user/1/0/?token='.$this->token, [
			'reason' => 'hello there, this is a test',
			'image_url' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertStatus(201);

	}

	/** @test */
	function reportStory(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/report/story/1/?token='.$this->token, [
			'reason' => 'hello there, this is a test'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/report/story/1/?token='.$this->token, [
			'reason' => 'hello there, this is a test',
			'image_url' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertStatus(201);
	}
	/***************************** Report (END) ************************************/

	
}
