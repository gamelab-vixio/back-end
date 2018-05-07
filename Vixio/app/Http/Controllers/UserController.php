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
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function login(Request $request){
    	$this->validate($request, [
    		'email' => 'required|email',
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

    public function getUser(){
        $userID = Auth::user()->id;
        $user = User::where('id',$userID)->get(array('name', 'email', 'image_url'));

        return response()->json($user ,201);
    }

    public function uploadImage(Request $request){
        $this->validate($request, [
            'photo' => 'required'
        ]);

        if(!$request->file('photo')->isvalid() && $request->has('image')){
            $response = [
                'message' => 'Something wrong with the photo!'
            ];
            return response()->json($response ,400);
        }

        $userID = Auth::user()->id;

        //store photo
        $profile = 'profile.'.$request->file('photo')->extension();
        $path = './image/user/'.$userID.'/';
        if (! File::exists(public_path().$path)) {
            File::makeDirectory(public_path().$path, 0755, true, true);
        }
        $path = $path.$profile;
        Image::make($request->file('photo'))->save($path);

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
            $image = Image::make(public_path().'/'.$imageURL)->resize(300,300);
        else
            $image = Image::make(public_path().'/image/default-user.png')->resize(300,300);

        return $image->response('jpeg');
    }

    //put e-mail verificaton then create the user
    public function signup(Request $request){
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email|unique:users',
    		'password' => 'required'
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

    public function history(){
        $userID = Auth::user()->id;

        $stories = StoryPlayed::select(['id','story_id','user_id', 'created_at'])->where('user_id', $userID)->with(['story' => function($q){
            $q->where('publish', 1)->where('active', 1)->get(['id','user_id','title', 'description','image_url', 'publish','active','year_of_release']);
        }
        ])->get();

        return response()->json($stories , 200);
    }

    //admin
    public function userList(){
        $user = User::withRole('user')->select(array('name','email','image_url'))->paginate(10);

        return response()->json($user, 200);
    }

    public function addAdmin(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $admin = Role::where('name', 'admin')->first();

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->attachRole($admin);

        $user->save();

        $response = ['message' => 'Successfully create new admin'];

        return response()->json($response, 201);
    }
}
