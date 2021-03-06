<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Blog;
use App\BlogComment;
use Auth;
use Illuminate\Support\Facades\Storage;
use File;
use Image;

class BlogController extends Controller
{
    public function getPublishedBlog(){
    	$blog = Blog::select(['id', 'title', 'content', 'image_url', 'status', 'updated_at'])->where('status', 1)->orderBy('updated_at', 'desc')->paginate(6);

        foreach ($blog as $key => $post) {
            $post['image_url'] = $this->loadImage($post->id);
        }

    	return response()->json($blog, 200);
    }

    public function getPost($bid){
        $post = Blog::select(['id', 'title', 'content', 'image_url', 'status', 'updated_at'])->with([
                    'blogComment' => function($q){
                        $q->Select(['id','blog_id','user_id','comment','comment_parent_id','created_at'])->whereNull('comment_parent_id')->orderBy('created_at','desc')->get();
                    },
                    'blogComment.user:id,name,email,image_url',
                    'blogComment.reply' => function($q){
                        $q->select(['blog_id','user_id','comment_parent_id','comment','created_at'])->whereNotNull('comment_parent_id')->orderBy('created_at','desc')->get();
                    },
                    'blogComment.reply.user:id,name,email,image_url'
                    ])
                ->where('status', 1)->orderBy('updated_at', 'desc')->find($bid);

        $post['image_url'] = $this->loadImage($bid);

        return response()->json($post, 200);
    }

    public function createComment(Request $request, $bid, $cpid = null){
        $this->validate($request, [
            'comment' => 'required'
        ]);

        $userID = Auth::user()->id;

        if(User::find($userID)->commentable){
            $blogComment = new BlogComment();

            $blogComment->blog_id = $bid;
            $blogComment->user_id = $userID;
            $blogComment->comment_parent_id = $cpid;
            $blogComment->comment = $request->input('comment');

            $blogComment->save();

            $response = [
                'message' => 'Comment Successfully pushed!'
            ];
        }else{
            $response = [
                'message' => 'Your ID has been banned and cannot comment.'
            ];
        }
        
        return response()->json($response ,201);
    }

    //admin
    public function createBlog(Request $request){
        $this->validate($request, [
            'title' => 'required|unique:blogs',
            'content' => 'required',
            'status' => 'required'
        ]);


        $blog = new Blog();

        $userID = Auth::user()->id;

        $blog->title = $request->input('title');
        $blog->user_id = $userID;
        $blog->content = $request->input('content');
        $blog->status = $request->input('status');

        $blog->save();

        $bid = $blog->id;

        //store image
        if($request->has('photo') && $request->file('photo')->isvalid()){
            $image = 'image.'.$request->file('photo')->extension();
            $path = 'image/blog/'.$bid.'/';
            if (! File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true, true);
            }
            $path = $path.$image;
            
            Image::make($request->file('photo'))->save(public_path($path));

            $blog->image_url = $path;

            $blog->save();
        }

        $request->session()->flash('message', 'New blog post has been created');

        return back();
    }

    public function loadImage($bid){
        $imageURL = Blog::find($bid)->image_url;
        
        if(!is_null($imageURL))
            $image = Image::make(public_path($imageURL))->resize(600,400)->encode('jpeg', 75);
        else
            $image = Image::make(public_path().'/image/default-blog.png')->resize(600,400)->encode('png', 75);
        
        return base64_encode($image);
    }

    public function getPublishedBlogAdmin(){
        $blog = Blog::where('status', 1)->orderBy('updated_at', 'desc')->get(['id', 'title', 'content', 'image_url', 'status', 'updated_at']);

        $data = [
            'data-table' => 'Published Posts',
            'blog' => $blog
        ];

        return view('/pages/blogDashboard')->with('data', $data);
    }

    public function getUnpublishBlog(){
        $blog = Blog::where('status', 0)->orderBy('updated_at', 'desc')->get(['id', 'title', 'content', 'image_url', 'status', 'updated_at']);

        $data = [
            'data-table' => 'Unpublish Posts',
            'blog' => $blog
        ];

        return view('/pages/blogDashboard')->with('data', $data);
    }

    public function updateBlog(Request $request, $bid){
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required'
        ]);

        $blog = Blog::findOrFail($bid);

        if($blog->title != $request->input('title')){
            $this->validate($request, ['title' => 'unique:blogs']);
        }

        //store image
        if($request->has('photo') && $request->file('photo')->isvalid()){
            $image = 'image.'.$request->file('photo')->extension();
            $path = 'image/blog/'.$bid.'/';
            if (! File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true, true);
            }
            $path = $path.$image;
            
            Image::make($request->file('photo'))->save(public_path($path));

            $blog->image_url = $path;
        }

        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->status = $request->input('status');

        $blog->save();

        $request->session()->flash('message', 'Post updated successfully');

        return back();
    }

    public function deleteBlog(Request $request, $bid){
        $blog = Blog::findOrFail($bid);

        $path = 'image/blog/'.$bid.'/';

        File::deleteDirectory(public_path($path));

        $blog->delete();

        $request->session()->flash('message', 'Post deleted successfully');

        return back();
    }
}
