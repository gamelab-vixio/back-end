<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserReport;
use Auth;

class UserReportController extends Controller
{
    public function reportUser(Request $request, $reported_user_id, $type){
    	$this->validate($request,[
    		'reason' => 'required',
		]);

    	$reporterUserID = $userID = Auth::user()->id;

        $imageURL = NULL;

        if($request->has(['imageURL'])){
            $imageURL = $request->input('imageURL');
        }

        $report = UserReport::updateOrCreate(
            ['reporter_user_id' => $reporterUserID, 'comment_type' => $type, 'user_id' => $reported_user_id],
            ['reason' => $request->input('reason'), 'image_url' => $imageURL]
        );

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
