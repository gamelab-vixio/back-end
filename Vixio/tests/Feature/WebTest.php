<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Session;
use App\User;
use Auth;
class WebTest extends TestCase{

	// use RefreshDatabase;
	// use WithoutMiddleware;
	use DatabaseTransactions;

	protected $header;
	protected $user;

	public function setUp(){
		parent::setUp();

		Session::start();

		$this->header = [
			'X-Requested-With' => 'XMLHttpRequest',
			'Content-Type' => 'application/json'
		];

		$this->user = User::find(1);
        
	}

	/***************************** User (START) ************************************/
	/** @test */
	function login(){
		//login page
		$response = $this->get('/login');

        $response->assertStatus(200);

		//try to login
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/login',[
			'_token' => csrf_token(),
			'email' => 'Witting.Ava@example.net',
			'password' => '123123'
		]);

		//redirect on success
	    $response->assertStatus(302);
	    $response->assertRedirect('/');
	}

	/** @test */
	function dashboard(){
		$response = $this->actingAs($this->user)->get('/');
		$response->assertStatus(200);
	}
	/***************************** User (END) ************************************/

	/***************************** Blog (START) ************************************/
	/** @test */
	function create_post_view(){
		$response = $this->actingAs($this->user)->get('/blog/create');
		$response->assertStatus(200);
	}

	/** @test */
	function published_post(){
		$response = $this->actingAs($this->user)->get('/blog/Published Posts');
		$response->assertStatus(200);
	}

	/** @test */
	function unpublish_post(){
		$response = $this->actingAs($this->user)->get('/blog/Unpublish Posts');
		$response->assertStatus(200);
	}

	/** @test */
	function create_a_post(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/blog/createBlog',[
			'_token' => csrf_token(),
			'title' => "this is a drill",
			'content' => "this is not a drill",
			'status' => 1 //publish
		]);

		$response->assertRedirect('/');

		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/blog/createBlog',[
			'_token' => csrf_token(),
			'title' => "this is a drill",
			'content' => "this is not a drill",
			'status' => 1 //publish
			'photo' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function update_a_blog(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/blog/updateBlog/1',[
			'_token' => csrf_token(),
			'title' => "this is a drill",
			'content' => "this is not a drill",
			'status' => 1 //publish
		]);

		$response->assertRedirect('/');
	}

	/***************************** Blog (END) ************************************/
}
