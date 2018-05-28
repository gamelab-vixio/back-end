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
class BlogWebTest extends TestCase{

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
			'title' => "this is another test",
			'content' => "this is not a drill",
			'status' => 1, //publish
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

		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/blog/updateBlog/1',[
			'_token' => csrf_token(),
			'title' => "this is not a drill",
			'content' => "this is not a drill",
			'status' => 1, //publish
		]);

		$response->assertRedirect('/');

		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/blog/updateBlog/1',[
			'_token' => csrf_token(),
			'title' => "this is something else",
			'content' => "this is not a drill",
			'status' => 1, //publish
			'photo' => UploadedFile::fake()->image('avatar.jpg'),
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function delete_a_post(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/blog/deleteBlog/1',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');
	}

	/***************************** Blog (END) ************************************/

	/** @test */
	function user_report_list(){
		$response = $this->actingAs($this->user)->get('/report/user');
		$response->assertStatus(200);
	}

	/** @test */
	function ban_user(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/report/user/ban/5',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');
	}

	/** @test */
	function unban_user(){
		$response = $this->actingAs($this->user)->withHeaders($this->header)->json('POST', '/report/user/unban/5',[
			'_token' => csrf_token(),
		]);

		$response->assertRedirect('/');
	}

}
