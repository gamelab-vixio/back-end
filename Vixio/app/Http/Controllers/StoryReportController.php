<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use App\StoryReport;
use Auth;

class StoryReportController extends Controller
{
    public function reportStory(Request $request, $story_id){
    	$this->validate($request,[
    		'reason' => 'required',
		]);

    	$reporterUserID = $userID = Auth::user()->id;

        $imageURL = NULL;

		if($request->has(['imageURL'])){
			$imageURL = $request->input('imageURL');
		}
		
        $report = StoryReport::updateOrCreate(
            ['reporter_user_id' => $reporterUserID, 'story_id' => $story_id],
            ['reason' => $request->input('reason'), 'image_url' => $imageURL]
        );

		$response = [
			'message' => 'Report submitted!'
		];
		return response()->json($response ,201);
    }

    public function getReport(){
    	$reports = Story::select(['id','user_id','title', 'active'])->with(['reportedStory' => function($q){
    		$q->with(['reported:id,user_id,title', 'reported.user:id,name,email', 'reporter:id,name,email'])->get(['id', 'story_id','reporter_user_id','reason','image_url']);
    	}])->has('reportedStory','>',0)->withCount(['reportedStory'])->orderBy('reported_story_count','desc')->where('active', 1)->paginate(10);

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
