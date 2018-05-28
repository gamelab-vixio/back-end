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

	/***************************** Documentation (START) ************************************/
	/** @test */
	function get_title(){
		$response = $this->actingAs($this->user)->get('/docs/title');
		$response->assertStatus(200);
	}

	/** @test */
	function get_subtitle(){
		$response = $this->actingAs($this->user)->get('/docs/subtitle');
		$response->assertStatus(200);
	}

	/** @test */
	function get_content(){
		$response = $this->actingAs($this->user)->get('/docs/content');
		$response->assertStatus(200);
	}

	/** @test */
	function create_title(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/createTitle',[
			'_token' => csrf_token(),
			'title' => "this is a drill",
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function create_subtitle(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/createSubtitle',[
			'_token' => csrf_token(),
			'titleID' => 1,
			'subtitle' => "this is not a drill",
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function create_content(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/createContent',[
			'_token' => csrf_token(),
			'subtitleID' => 1,
			'header' => "i am drilling",
			'content' => "yes it is"
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function edit_docs(){
		//title
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/adminUpdate/1',[
			'_token' => csrf_token(),
			'title' => "hello dolly!"
		]);

		$response->assertRedirect('/');

		//subtitle
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/adminUpdate/1/1',[
			'_token' => csrf_token(),
			'titleID' => 1,
			'subtitle' => "i want me"
		]);

		$response->assertRedirect('/');

		//content
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/adminUpdate/1/1/1',[
			'_token' => csrf_token(),
			'subtitleID' => 1,
			'header' => 'i want me too',
			'content' => 'be happy...'
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function delete_docs(){
		//content
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/adminDelete/1/1/1',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');

		//subtitle
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/adminDelete/1/1',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');

		//title
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/docs/adminDelete/1',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');
	}
	/***************************** Documentation (END) ************************************/

}
