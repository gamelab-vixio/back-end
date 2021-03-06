<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\StoryPlayed;
use App\Permission;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Auth;
use Image;
use Hash;
use App\Story;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function login(Request $request){
    	$this->validate($request, [
    		'email' => 'required|email|max:255',
    		'password' => 'required'
		]);
    	$credentials = $request->only('email', 'password');
    	try{
    		if(!$token = JWTAuth::attempt($credentials)){
    			return response()->json([
    				'message' => 'Invalid Credentials!'
    			], 401);
    		}
    	}catch(JWTException $e){
    		return response()->json([
    			'message' => 'Could not create token!'
			], 500);
    	}
    	return response()->json([
    		'token' => $token
    	], 200);
    }

    //put e-mail verificaton then create the user
    public function signup(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->save();

        $role = Role::where('name', 'user')->first();

        $user->attachRole($role);

        $response = [
            'message' => 'Successfully created user!'
        ];
        return response()->json($response ,201);
    }

    public function changePassword(Request $request){
        $this->validate($request,[
            'currentPassword' => 'required|min:6',
            'newPassword' => 'required|confirmed|different:currentPassword|min:6'
        ]);

        $userID = Auth::user()->id;
        $user = User::findOrFail($userID);

        $currentPassword = $request->input('currentPassword');
        $newPassword = $request->input('newPassword');

        if(Hash::check($currentPassword, $user->password)) {
            $user->password = bcrypt($newPassword);
            $user->save();

            $response = [
                'message' => 'Successfully changed password'
            ];

        }else{
            $response = [
                'message' => 'Please enter the old password like your current password',
                'old' => bcrypt($currentPassword),
                'current' => $user->password
            ];
        }

        return response()->json($response, 200);

    }

    public function getUser(){
        $userID = Auth::user()->id;
        $user = User::select(['name','email', 'image_url'])->findOrFail($userID);

        $user['image_url'] = $this->loadImage($userID);

        return response()->json($user ,201);
    }

    public function uploadImage(Request $request){
        $this->validate($request, [
            'photo' => 'required'
        ]);

        if($request->has('photo') && !$request->file('photo')->isvalid()){
            $response = [
                'message' => 'Something wrong with the photo!'
            ];
            return response()->json($response ,400);
        }

        $userID = Auth::user()->id;
        
        //store photo
        $profile = 'profile.'.$request->file('photo')->extension();
        $path = 'image/user/'.$userID.'/';
        if (! File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0755, true, true);
        }
        $path = $path.$profile;
        Image::make($request->file('photo'))->save(public_path($path));

        $user = User::find($userID);
        $user->image_url = $path;
        $user->save();

        $response = [
            'message' => 'Successfully put a new photo'
        ];

        return response()->json($response ,201);

    }

    public function loadImage(){
        $userID = Auth::user()->id;
        $imageURL = User::find($userID)->image_url;
        if(!is_null($imageURL))
            $image = Image::make(public_path($imageURL))->resize(300,300)->encode('jpeg', 75);
        else
            $image = Image::make(public_path().'/image/default-user.png')->resize(300,300)->encode('png', 75);

        return base64_encode($image);
    }

    public function history(){
        $userID = Auth::user()->id;

        $stories = StoryPlayed::select(['id','story_id','user_id', 'created_at'])->where('user_id', $userID)->orderBy('created_at', 'DESC')->with([
            'story' => function($q){
            $q->select(['id','user_id','title','image_url', 'publish','active','year_of_release'])->where('publish', 1)->where('active', 1)->get();
        }, 'story.user:id,name','story.storyCategory:story_id,category_type_id','story.storyCategory.categoryType:id,name',
            'story.storyReview'=>function($query){
            $query->groupBy('story_id')->selectRaw('story_id, TRUNCATE(avg(star), 1) as star');
        }
        ])->paginate(10);

        foreach ($stories as $i => $story) {
            $story['image_url'] = $this->loadStoryImage($story['id']);
        }

        return response()->json($stories , 200);
    }

    public function loadStoryImage($sid){
        $imageURL = Story::find($sid)->image_url;
        
        if(!is_null($imageURL))
            $image = Image::make(public_path($imageURL))->resize(400,300)->encode('jpeg', 75);
        else
            $image = Image::make(public_path().'/image/default-story.png')->resize(400,300)->encode('png', 75);

        return base64_encode($image);
    }

    //admin
    public function userList(){
        $user = User::withRole('user')->select(array('name','email','image_url'))->get();

        return view('/pages/userList')->with('data',$user);
    }

    public function addAdmin(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $admin = Role::where('name', 'admin')->first();

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->save();

        $user->attachRole($admin);

        $request->session()->flash('message', 'New user admin has been created');

        return back();
    }
}
