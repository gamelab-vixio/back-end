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
class StoryApiTest extends TestCase{

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
			'categories' => json_encode([2,3,4,7]),
			'description' => 'testing purpose'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/create/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => json_encode([2,3,4,7]),
			'description' => 'testing purpose',
			'photo' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/create/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => json_encode([2,3,4,7]),
			'description' => 'testing purpose',
			'photo' => UploadedFile::fake()->image('avatar.jpg'),
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
	function searchStoryList(){
		$response = $this->get('/api/story/search/quos');

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
	function searchWriterStoryList(){
		$response = $this->get('/api/story/writer/search/quos');

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
	function get_most_popular(){
		$response = $this->get('/api/story/getMostPopular');

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
	function get_new_available(){
		$response = $this->get('/api/story/getNewAvailable');

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
	function get_user_based(){
		$response = $this->get('/api/story/getUserBased');

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
	function get_item_based(){
		$response = $this->get('/api/story/getItemBased');

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
			'stories' => [
				'id','user_id','title', 'description','image_url','publish','content','active','year_of_release','played',
				'story_category' => [
					'*' => [
							'story_id','category_type_id',
							'category_type' => ['id', 'name']
						]
				]
			],
			'genres' => [
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
			]
		]);

		$response->assertStatus(200);

	}

	/** @test */
	function writer_story_update(){

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/writer/update/1/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => json_encode([2,3,4,7]),
			'description' => 'testing purpose'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/story/writer/update/1/?token='.$this->token, [
			'title' => 'demo test',
			'categories' => json_encode([2,3,4,7]),
			'description' => 'testing purpose',
			'photo' => UploadedFile::fake()->image('avatar.jpg'),
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

	/** @test */
	function reportStory(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/report/story/1/?token='.$this->token, [
			'reason' => 'hello there, this is a test'
		]);

		$response->assertStatus(201);

		$response = $this->withHeaders($this->header)->json('POST', '/api/report/story/1/?token='.$this->token, [
			'reason' => 'hello there, this is a test',
			'photo' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertStatus(201);
	}
	/***************************** Report (END) ************************************/
}
