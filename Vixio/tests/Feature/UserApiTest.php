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

	/** @test */
	function uploadImage(){
		$response = $this->withHeaders($this->header)->json('POST', '/api/user/uploadImage/?token='.$this->token, [
			'photo' => UploadedFile::fake()->image('avatar.jpg')
		]);

		$response->assertStatus(201);
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
}
