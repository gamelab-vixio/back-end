<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Story;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::withRole('user')->count();
        $story = Story::where('active', 1)->count();

        $data =[
            'user' => $user,
            'story' => $story
        ];
        return view('pages/dashboard')->with('data',$data);
    }
}
