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

        //store image
        if($request->has('photo') && $request->file('photo')->isvalid()){
            $image = 'report_'.$reporterUserID.'.'.$request->file('photo')->extension();
            $path = './image/report/user/'.$reported_user_id.'/';
            if (! File::exists(public_path().$path)) {
                File::makeDirectory(public_path().$path, 0755, true, true);
            }
            Image::make($request->file('photo'))->save($path.$image);
            $path = $path.$image;

            $imageURL = $path;
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
        $reports = User::select(['id','name','email', 'commentable'])->with(['reportedUser' => function ($q){
            $q->with(['reported:id,name,email', 'reporter:id,name,email'])->get(['id','user_id','reporter_user_id', 'reason', 'image_url', 'comment_type']);
        }])->withCount(['reportedUser'])->has('reportedUser', '>', 0)->orderBy('reported_user_count', 'desc')->orderBy('commentable', 'desc')->get();

        return view('/pages/userBan')->with('data', $reports);
    }

    public function banUser(Request $request, $uid){
        $user = User::find($uid);

        $user->commentable = false;

        $user->save();

        $request->session()->flash('message', $user['name'].' has been banned');

        return back();
    }

    public function unbanUser(Request $request, $uid){
        $user = User::find($uid);

        $user->commentable = true;

        $user->save();

        $request->session()->flash('message', $user['name'].' has been unban');

        return back();
    }
}
