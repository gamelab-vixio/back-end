<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Story;
use App\StoryCategory;
use App\CategoryType;
use App\StoryReview;
use App\StoryComment;
use App\StoryPlayed;
use App\User;
use Auth;
use Carbon\Carbon;
use File;
use Image;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class StoryController extends Controller
{
    public function createStory(Request $request){
    	$this->validate($request,[
    		'title' => 'required',
    		'categories' => 'required',
    		'description' => 'required',
		]);

		$userID = Auth::user()->id;

		$story = new Story();

		$story->user_id = $userID;
		$story->title = $request->input('title');
		$story->description = $request->input('description');

		if($request->has(['content']))
			$story->content = $request->input('content');

		$story->save();

		$sid = $story->id;

        //store image
        if($request->has(['photo']) && $request->file('photo')->isvalid() ){
            $image = 'image.'.$request->file('photo')->extension();
            $path = 'image/story/'.$sid.'/';
            if (! File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true, true);
            }

            $path = $path.$image;

            Image::make($request->file('photo'))->save(public_path($path));
            
            $story->image_url = $path;
        }
        $story->save();
        //new one
		$categories = json_decode($request->input('categories'));
        //old one
        // $categories = $request->input('categories');

		$length = count($categories);

		for($i = 0; $i < $length; $i++){
			$storyCategory = new StoryCategory();
			$storyCategory->story_id = $sid;
			$storyCategory->category_type_id = $categories[$i];
			$storyCategory->save();
		}

		$response = [
			'message' => 'Successfully created a new story!'
		];

		return response()->json($response ,201);
    }



    public function writerGetStoryList(){
    	$userID = Auth::user()->id;

    	$stories = Story::select(['id','user_id','title','image_url', 'publish','active','year_of_release','played'])->with(['storyCategory:story_id,category_type_id','storyCategory.categoryType:id,name', 'storyReview'=>function($query){
            $query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
        }])->where('user_id', '=', $userID)->paginate(6);

        foreach($stories as $story){
            if(!is_null($story->image_url)){
                $story->image_url = $this->loadImage($sid);
            }
        }

        return response()->json($stories, 200);
    }

    public function writerGetStory($sid){
    	$userID = Auth::user()->id;
    	$story = Story::select(['id','user_id','title', 'description','image_url', 'publish','active','year_of_release','played'])->with(['storyCategory:story_id,category_type_id','storyCategory.categoryType:id,name', 'storyReview'=>function($query){
            $query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
        }])->where('user_id', '=', $userID)->find($sid);

        $story->image_url = $this->loadImage($sid);

        return response()->json($story, 200);
    }

    public function writerGetContent($sid){
    	$userID = Auth::user()->id;

    	$content = Story::select(['user_id','content'])->where('user_id', '=', $userID)->find($sid);    	

        return response()->json($content, 200);
    }

    public function writerGetCategoryList(){
    	$categories = CategoryType::where('genre_id','!=','1')->get(['id','genre_id','name']);

        return response()->json($categories, 200);
    }

    public function writerUpdateStory(Request $request, $sid){
    	$this->validate($request,[
    		'title' => 'required',
    		'categories' => 'required',
    		'description' => 'required',
		]);

    	$userID = Auth::user()->id;
    	$story = Story::where('user_id','=', $userID)->findOrFail($sid);

		//store image
        if($request->has(['photo']) && $request->file('photo')->isvalid() ){
            $image = 'image.'.$request->file('photo')->extension();
            $path = 'image/story/'.$sid.'/';
            if (! File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true, true);
            }

            $path = $path.$image;

            Image::make($request->file('photo'))->save(public_path($path));
            
            $story->image_url = $path;
        }


		$story->user_id = $userID;
		$story->title = $request->input('title');
		$story->description = $request->input('description');
		if($request->has(['content']))
		$story->content = $request->input('content');
		$story->save();

		//delete old categories
		$storyCategory = StoryCategory::where('story_id','=',$sid)->delete();

        //new one
        $categories = json_decode($request->input('categories'));
        //old one
        // $categories = $request->input('categories');
        
		$length = count($categories);

		for($i = 0; $i < $length; $i++){
			$storyCategory = new StoryCategory();
			$storyCategory->story_id = $sid;
			$storyCategory->category_type_id = $categories[$i];
			$storyCategory->save();
		}

		$response = [
			'message' => 'Story has been updated!'
		];

		return response()->json($response ,201);
    }

    public function writerPublishedStory(Request $request, $sid){
        $this->validate($request,[
            'ink' => 'required',
        ]);

    	$userID = Auth::user()->id;
    	$story = Story::where('user_id','=', $userID)->findOrFail($sid);
		//create temp file
		$path = '/story/'.$userID.'/'.$story->title.'.ink';
		Storage::put($path, $request->input('ink'));
		
        //convert ink to json
        //Windows
		// $process = new Process('inklecate.exe "../storage/app'.$path.'"');
        //Linux
        $process = new Process('mono "'.public_path('inklecate.exe').'" "'.public_path('../storage/app'.$path).'"');
		$process->run();

		// executes after the command finishes
		if (!$process->isSuccessful()) {

		    throw new ProcessFailedException($process);
		}

		//put json to db
		$inkle = Storage::get($path.'.json');
		$story->inkle = $inkle;
		$story->publish = 1;
		$story->year_of_release = Carbon::now();
		$story->save();

		//delete temp folder
		Storage::deleteDirectory('/story/'.$userID);

		$response = [
			'message' => 'Story has been published!'
		];

		return response()->json($response ,200);
    }

    public function writerUnpublishedStory($sid){
    	$userID = Auth::user()->id;
    	$story = Story::where('user_id','=', $userID)->findOrFail($sid);

    	$story->publish = 0;
		$story->year_of_release = null;
		$story->save();

		$response = [
			'message' => 'Story has been unpublish!'
		];

		return response()->json($response ,200);
    }

    public function writerDeleteStory($sid){
    	$userID = Auth::user()->id;
    	$story = Story::where('user_id','=', $userID)->findOrFail($sid);

        $path = 'image/story/'.$sid.'/';

        File::deleteDirectory(public_path($path));


    	$story->delete();

    	$response = [
			'message' => 'Story has been deleted!'
		];

		return response()->json($response ,200);

    }
    
    //write review
    public function addReviewStory(Request $request, $sid){
    	$this->validate($request,[
    		'star' => 'required|integer|between:0,5',
		]);

    	$userID = Auth::user()->id;

    	$storyReview = StoryReview::updateOrCreate(
    		['user_id' => $userID, 'story_id' => $sid],
    		['star' => $request->input('star')]
		);

    	$response = [
			'message' => 'Thank you for reviewing this story.'
		];

		return response()->json($response, 200);

    }

    public function createComment(Request $request, $sid, $cpid = null){
        $this->validate($request, [
            'comment' => 'required'
        ]);

        $userID = Auth::user()->id;

        if(User::find($userID)->commentable){
            $storyComment = new StoryComment();

            $storyComment->story_id = $sid;
            $storyComment->user_id = $userID;
            $storyComment->comment_parent_id = $cpid;
            $storyComment->comment = $request->input('comment');

            $storyComment->save();

            $response = [
                'message' => 'Comment Successfully pushed!'
            ];
        }else{
            $response = [
                'message' => 'Your ID has been banned and cannot comment.'
            ];
        }

        return response()->json($response ,201);
    }

    public function getMLList(){
        //Test
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'vixio-backend.gamelabnetwork.com/api/story/getStoryList');

        $story = json_decode($res->getBody()->getContents(), true);

        $data = [
            'statusCode' => $res->getStatusCode(),
            'data' => $story
        ];

        return response()->json($data, 200);
    }

    public function getStoryList(){
    	$stories = Story::select(['id','user_id','title','image_url', 'publish','active','year_of_release'])->with(['user:id,name','storyCategory:story_id,category_type_id','storyCategory.categoryType:id,name', 'storyReview'=>function($query){
    		$query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
    	}])->where('active', '=', '1')->where('publish', '=', '1')->paginate(5);

        foreach($stories as $story){
            if(!is_null($story->image_url)){
                $story->image_url = $this->loadImage($sid);
            }
        }

        return response()->json($stories, 200);
    }

    public function getStory($sid){
        $story = Story::select(['id','user_id','title', 'description','image_url', 'publish','active','year_of_release'])->with([
            'user:id,name,email,image_url',
            'storyCategory:story_id,category_type_id','storyCategory.categoryType:id,name',
            'storyReview'=>function($query){
                $query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
            },
            'storyComment' => function($q){
                $q->select(['id', 'story_id', 'user_id', 'comment_parent_id', 'comment', 'created_at'])->whereNull('comment_parent_id')->orderBy('created_at', 'desc')->get();
            },
            'storyComment.user:id,name,email,image_url',
            'storyComment.reply' => function($q){
                $q->select(['story_id', 'user_id', 'comment_parent_id', 'comment', 'created_at'])->whereNotNull('comment_parent_id')->orderBy('created_at', 'desc')->get();
            },
            'storyComment.reply.user:id,name,email,image_url'
            ])->where('active', '=', '1')->where('publish', '=', '1')->find($sid);

        $story->image_url = $this->loadImage($sid);

        return response()->json($story, 200);
    }

    public function loadImage($sid){
        $imageURL = Story::find($sid)->image_url;
        
        if(!is_null($imageURL))
            $image = Image::make(public_path($imageURL))->resize(400,300)->encode('jpeg', 75);
        else
            $image = Image::make(public_path().'/image/default-story.png')->resize(400,300)->encode('png2wbmp(pngname, wbmpname, dest_height, dest_width, threshold)', 75);

        return base64_encode($image);
    }

    public function searchStory($name = NULL){
        if(strlen($name) < 3){
            $name = NULL;
        }
        $stories = Story::select(['id','user_id','title','image_url', 'publish','active','year_of_release'])->with(['user:id,name','storyCategory:story_id,category_type_id','storyCategory.categoryType:id,name', 'storyReview'=>function($query){
                $query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
            }])->where('active', '=', '1')->where('publish', '=', '1')->where('title','LIKE', '%'.$name.'%')->paginate(5);

            return response()->json($stories, 200);
    }

    public function addPlayed($sid){
        try{
            if(JWTAuth::parseToken()->authenticate()){
                $userID = Auth::user()->id;
                $played = new StoryPlayed();
                $played->user_id = $userID;
                $played->story_id = $sid;

                $played->save();
            }
        }catch(JWTException $e){

        }
        $story = Story::where('active', '=', '1')->where('publish', '=', '1')->find($sid);

        $story->played = $story->played + 1;

        $story->save();

        $response = ['message' => 'Let\'s play the story!'];

        return response()->json($response, 200);
    }

    public function playStory($sid){
    	$story = Story::select(['inkle'])->where('active', '=', '1')->where('publish', '=', '1')->find($sid);

        return response()->json($story, 200);
    }

    //admin
    public function storyList(){
        $story = Story::select(['id','user_id','title', 'description','image_url', 'publish','active','played' ,'year_of_release','created_at'])->with(['user:id,name'])->get();

        return view('/pages/storyList')->with('data', $story);
    }
}
