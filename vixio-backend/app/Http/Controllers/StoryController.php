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
use Auth;
use Carbon\Carbon;
use File;
use Image;

class StoryController extends Controller
{
    public function createStory(Request $request){
    	$this->validate($request,[
    		'title' => 'required',
    		'categories' => 'required|array',
    		'description' => 'required',
		]);

		$userID = Auth::user()->id;
		$story = new Story();

		if($request->has(['imageURL'])){
			$story->image_url = $request->input('imageURL');
		}
		$story->user_id = $userID;
		$story->title = $request->input('title');
		$story->description = $request->input('description');

		if($request->has(['content']))
			$story->content = $request->input('content');

		$story->save();

		$sid = $story->id;
		$categories = $request->input('categories');
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

        return response()->json($stories, 200);
    }

    public function writerGetStory($sid){
    	$userID = Auth::user()->id;
    	$story = Story::select(['id','user_id','title', 'description','image_url', 'publish','active','year_of_release','played'])->with(['storyCategory:story_id,category_type_id','storyCategory.categoryType:id,name', 'storyReview'=>function($query){
            $query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
        }])->where('user_id', '=', $userID)->find($sid);

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
    		'categories' => 'required|array',
    		'description' => 'required',
		]);

    	$userID = Auth::user()->id;
    	$story = Story::where('user_id','=', $userID)->findOrFail($sid);

		//store image
    	if($request->has(['photo']) && $request->file('photo')->isvalid() ){
	        $image = 'image.'.$request->file('photo')->extension();
	        $path = './image/story/'.$sid.'/';
	        if (! File::exists(public_path().$path)) {
	            File::makeDirectory(public_path().$path, 0755, true, true);
	        }
	        Image::make($request->file('photo'))->save($path.$image);
	        $path = $path.$image;

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

		$categories = $request->input('categories');
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

    public function writerLoadImage($sid){
        $imageURL = Story::find($sid)->image_url;
        
        if(!is_null($imageURL))
        	$image = Image::make(public_path().'/'.$imageURL)->resize(400,300);
        else
        	$image = Image::make(public_path().'/image/default-story.png')->resize(400,300);

        return $image->response('jpeg');
    }

    public function writerPublishedStory($sid){
    	$userID = Auth::user()->id;
    	$story = Story::where('user_id','=', $userID)->findOrFail($sid);
		//create temp file
		$path = '/story/'.$userID.'/'.$story->title.'.ink';
		Storage::put($path, $story->content);
		

		//convert ink to json
		$process = new Process('inklecate.exe "../storage/app'.$path.'"');
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
			'message' => 'Story has been unpublished!'
		];

		return response()->json($response ,200);
    }

    public function writerDeleteStory($sid){
    	$userID = Auth::user()->id;
    	$story = Story::where('user_id','=', $userID)->findOrFail($sid);

    	$story->delete();

    	$response = [
			'message' => 'Story has been deleted!'
		];

		return response()->json($response ,200);

    }
    
    //write review
    public function addReviewStory(Request $request, $sid){
    	$this->validate($request,[
    		'star' => 'required|numeric|between:0,5.0|regex:/^\d*(\.\d{1,1})?$/',
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

        $storyComment = new StoryComment();

        $storyComment->story_id = $sid;
        $storyComment->user_id = $userID;
        $storyComment->comment_parent_id = $cpid;
        $storyComment->comment = $request->input('comment');

        $storyComment->save();

        $response = [
            'message' => 'Comment Successfully pushed!'
        ];
        return response()->json($response ,201);
    }

    public function getStoryList(){
    	//tambahin cek ID buat kasih albert pake gazzle
    	$stories = Story::select(['id','user_id','title','image_url', 'publish','active','year_of_release'])->with(['user:id,name','storyCategory:story_id,category_type_id','storyCategory.categoryType:id,name', 'storyReview'=>function($query){
    		$query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
    	}])->where('active', '=', '1')->where('publish', '=', '1')->paginate(6);

        return response()->json($stories, 200);
    }

    public function getStory($sid){
    	$story = Story::select(['id','user_id','title', 'description','image_url', 'publish','active','year_of_release'])->with(['user:id,name,email,image_url','storyCategory:story_id,category_type_id','storyCategory.categoryType:id,name', 'storyReview'=>function($query){
            $query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
        }])->where('active', '=', '1')->where('publish', '=', '1')->find($sid);

        return response()->json($story, 200);
    }

    public function playStory($sid){
    	$story = Story::select(['inkle'])->where('active', '=', '1')->where('publish', '=', '1')->find($sid);    	

        return response()->json($story, 200);
    }
}