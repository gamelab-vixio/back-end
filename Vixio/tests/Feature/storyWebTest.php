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
class StoryWebTest extends TestCase{

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
	/***************************** Story (START) ************************************/
	/** @test */
	function story_list(){
		$response = $this->actingAs($this->user)->get('/story/list');
		$response->assertStatus(200);
	}

	/***************************** Story (END) ************************************/

	/***************************** Category (START) ************************************/
	/** @test */
	function genre_list(){
		$response = $this->actingAs($this->user)->get('/category/genre');
		$response->assertStatus(200);
	}

	/** @test */
	function type_list(){
		$response = $this->actingAs($this->user)->get('/category/type');
		$response->assertStatus(200);
	}

	/** @test */
	function create_genre(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/category/genre/create',[
			'_token' => csrf_token(),
			'genre' => 'no more drilling'
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function create_type(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/category/type/create',[
			'_token' => csrf_token(),
			'genreID' => 1,
			'name' => 'oh no'
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function genre_update(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/category/genre/adminUpdate/1',[
			'_token' => csrf_token(),
			'genre' => 'oh yes!'
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function type_update(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/category/type/adminUpdate/1',[
			'_token' => csrf_token(),
			'genreID' => 1,
			'name' => 'oh no'
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function genre_delete(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/category/genre/adminDelete/1',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function type_delete(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/category/type/adminDelete/1',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');
	}

	/***************************** Category (END) ************************************/

	/** @test */
	function story_report_list(){
		$response = $this->actingAs($this->user)->get('/report/story');
		$response->assertStatus(200);
	}
	
	/** @test */
	function ban_story(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/report/story/ban/5',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function unban_story(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/report/story/unban/5',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');
	}

}
