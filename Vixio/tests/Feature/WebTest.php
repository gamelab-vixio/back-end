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

	/***************************** Report (START) ************************************/
	/** @test */
	function user_report_list(){
		$response = $this->actingAs($this->user)->get('/report/user');
		$response->assertStatus(200);
	}

	/** @test */
	function story_report_list(){
		$response = $this->actingAs($this->user)->get('/report/story');
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

	/***************************** Report (END) ************************************/
}
