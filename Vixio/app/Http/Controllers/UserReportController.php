<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserReportController extends Controller
{
    public function reportUser(Request $request, $reported_user_id, $type){
    	$this->validate($request,[
    		'reason' => 'required',
		]);

    	$reporterUserID = $userID = Auth::user()->id;

		$report = new UserReport();

		if($request->has(['imageURL'])){
			$report->image_url = $request->input('imageURL');
		}
		$report->reason = $request->input('reason');
		$report->user_id = $reported_user_id;
		$report->reporter_user_id = $reporterUserID;
		$report->comment_type = $type;
        $report->save();

        $response = [
            'message' => 'Report submitted!'
        ];
        return response()->json($response ,201);
    }

    public function getReport(){
        $reports = User::select(['id','name','email'])->with(['reportedUser' => function ($q){
            $q->with(['reported:id,name,email', 'reporter:id,name,email'])->get(['id','user_id','reporter_user_id', 'reason', 'image_url', 'comment_type']);
        }])->has('reportedUser', '>', 0)->withCount(['reportedUser'])->orderBy('reported_user_count', 'desc')->get();

        return response()->json($reports, 200);
    }

    public function banUser($uid){
        $user = User::find($uid);

        $user->commentable = false;

        $user->save();
    }

    public function unbanUser($uid){
        $user = User::find($uid);

        $user->commentable = true;

        $user->save(); 
    }
}
