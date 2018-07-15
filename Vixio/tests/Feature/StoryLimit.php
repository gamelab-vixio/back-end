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
class StoryLimitTest extends TestCase{

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

	/** @test */
	function play_story(){
		$response = $this->get('/api/story/playStory/1');

		$response->assertJsonStructure(['inkle']);

		$response->assertStatus(200);
	}
}
