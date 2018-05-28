<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
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
		Session::start();

		$this->header = [
			'X-Requested-With' => 'XMLHttpRequest',
			'Content-Type' => 'application/json'
		];

		//change accordingly with the stories user_id (find stories id = 1 )
		//publish the story
		$user = User::find(88);

		$this->token = JWTAuth::fromUser($user);
        
        JWTAuth::setToken($this->token);
        
	}

	/***************************** Blog (START) ************************************/

	/** @test */
	function getPublishedBlog(){
		$response = $this->get('/api/blog/getPublishedBlog');
		
		$response->assertJsonStructure([
			'current_page',
			'data' =>[
			'*' => [
					'id',
					'title',
					'content',
					'image_url',
					'status',
					'updated_at'		
				]
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

	/** @test */
	function reportUser(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/report/user/1/0/?token='.$this->token, [
			'reason' => 'hello there, this is a test'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/report/user/1/0/?token='.$this->token, [
			'reason' => 'hello there, this is a test',
			'photo' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/report/user/1/1/?token='.$this->token, [
			'reason' => 'hello there, this is a test'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/report/user/1/1/?token='.$this->token, [
			'reason' => 'hello there, this is a test',
			'photo' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertStatus(201);

	}
}
