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
	function view_login(){
		//login page
		$response = $this->get('/login');

        $response->assertStatus(200);
	}
	/** @test */
	function login(){
		//try to login
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/login',[
			'_token' => csrf_token(),
			'email' => 'Witting.Ava@example.net',
			'password' => '123123'
		]);

		//redirect on success
	    $response->assertStatus(302);
	    $response->assertRedirect('/');

	    //logout page
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/logout',[
			'_token' => csrf_token(),
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

	/** @test */
	function user_list(){
		$response = $this->actingAs($this->user)->get('/user/list');
		$response->assertStatus(200);
	}

	/** @test */
	function add_admin_view(){
		$response = $this->actingAs($this->user)->get('/user/add');
		$response->assertStatus(200);
	}

	/** @test */
	function add_admin(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/user/addAdmin',[
			'_token' => csrf_token(),
			'name' => 'admin',
			'email' => 'admin@admin.com',
			'password' => 'yourguessisright',
			'password_confirmation' => 'yourguessisright'
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function forgot_password(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/password/email',[
			'_token' => csrf_token(),
			'email' => 'Zulauf.Brendon@example.com',
		]);

		$response->assertRedirect('/');
	}

	/***************************** User (END) ************************************/
}
