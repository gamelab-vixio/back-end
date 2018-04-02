<?php

namespace App\Http\Controllers;

use App\User;
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
        $user = User::find($userID)->get(array('name', 'email', 'image_url'));

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
            return response()->json($response ,201);
        }

        $userID = Auth::user()->id;

        //store photo
        $profile = 'profile.'.$request->file('photo')->extension();
        $path = './image/user/'.$userID.'/';
        if (! File::exists(public_path().$path)) {
            File::makeDirectory(public_path().$path, 0755, true, true);
        }
        Image::make($request->file('photo'))->save($path.$profile);
        $path = $path.$profile;

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
        $image = Image::make(public_path().'/'.$imageURL)->resize(300,300);

        return $image->response('jpeg');
    }

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

		$response = [
			'message' => 'Successfully created user!'
		];
		return response()->json($response ,201);
    }
}
