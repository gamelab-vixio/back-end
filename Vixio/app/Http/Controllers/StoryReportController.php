<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use Auth;

class StoryReportController extends Controller
{
    public function reportStory(Request $request, $story_id){
    	$this->validate($request,[
    		'reason' => 'required',
		]);

    	$reporterUserID = $userID = Auth::user()->id;

		$report = new StoryReport();

		if($request->has(['imageURL'])){
			$report->image_url = $request->input('imageURL');
		}
		$report->reason = $request->input('reason');
		$report->story_id = $story_id;
		$report->reporter_user_id = $reporterUserID;
		$report->save();

		$response = [
			'message' => 'Report submitted!'
		];
		return response()->json($response ,201);
    }

    public function getReport(){
    	$reports = Story::select(['id','user_id','title'])->with(['reportedStory' => function($q){
    		$q->with(['reported:id,user_id,title', 'reported.user:id,name,email', 'reporter:id,name,email'])->get(['id', 'story_id','reporter_user_id','reason','image_url']);
    	}])->has('reportedStory','>',0)->withCount(['reportedStory'])->orderBy('reported_story_count','desc')->get();

        return response()->json($reports, 200);
    }

    public function banStory($sid){
        $story = Story::find($sid);

        $story->active = false;

        $story->save();
    }

    public function unbanStory($sid){
        $story = Story::find($sid);

        $story->active = true;

        $story->save(); 
    }
}
