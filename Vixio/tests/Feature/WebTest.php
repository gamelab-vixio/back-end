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
class WeebTest extends TestCase{

	// use RefreshDatabase;
	use WithoutMiddleware;
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
		//signup
		$response = $this->withHeaders($this->header)->json('POST', '/login', [
			'_token' => csrf_token(),
			'email' => 'Witting.Ava@example.net',
			'password' => '123123'
		]);

	    $response->assertStatus(201);
	}
	/***************************** User (END) ************************************/
}
