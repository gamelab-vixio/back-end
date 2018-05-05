<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\BlogComment;
use Auth;
use Illuminate\Support\Facades\Storage;
use File;
use Image;

class BlogController extends Controller
{
    public function getPublishedBlog(){
    	$blog = Blog::where('status', 1)->orderBy('updated_at', 'desc')->get(['id', 'title', 'content', 'image_url', 'status', 'updated_at']);

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

        return response()->json($post, 200);
    }

    public function createComment(Request $request, $bid, $cpid = null){
        $this->validate($request, [
            'comment' => 'required'
        ]);

        $userID = Auth::user()->id;

        $blogComment = new BlogComment();

        $blogComment->blog_id = $bid;
        $blogComment->user_id = $userID;
        $blogComment->comment_parent_id = $cpid;
        $blogComment->comment = $request->input('comment');

        $blogComment->save();

        $response = [
            'message' => 'Comment Successfully pushed!'
        ];
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

        //store image
        if($request->has('photo') && $request->file('photo')->isvalid()){
            $image = 'image.'.$request->file('photo')->extension();
            $path = './image/blog/'.$request->input('title').'/';
            if (! File::exists(public_path().$path)) {
                File::makeDirectory(public_path().$path, 0755, true, true);
            }
            Image::make($request->file('photo'))->save($path.$image);
            $path = $path.$image;

            $blog->image_url = $path;
        }
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->status = $request->input('status');

        $blog->save();

        $response = [
            'message' => 'Successfully created a new blog!'
        ];
        return response()->json($response ,201);
    }

    public function loadImage($bid){
        $imageURL = Blog::find($bid)->image_url;
        
        if(!is_null($imageURL))
            $image = Image::make(public_path().'/'.$imageURL)->resize(600,400);
        else
            $image = Image::make(public_path().'//image/default-blog.png')->resize(600,400);
        
        return $image->response('jpeg');
    }

    public function getUnpublishedBlog(){
        $blog = Blog::where('status', 0)->orderBy('updated_at', 'desc')->get(['id', 'title', 'content', 'image_url', 'status', 'updated_at']);

        return response()->json($blog, 200);
    }

    public function updateBlog(Request $request, $bid){
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required'
        ]);

        $blog = Blog::findOrFail($bid);

        //store image
        if($request->has('photo') && $request->file('photo')->isvalid()){
            $image = 'image.'.$request->file('photo')->extension();
            $oldPath = './image/blog/'.$blog->title.'/';
            $path = './image/blog/'.$request->input('title').'/';
            if (! File::exists(public_path().$path) && File::exists(public_path().$oldPath)) {
                File::deleteDirectory(public_path().$oldPath);
                File::makeDirectory(public_path().$path, 0755, true, true);
            }
            Image::make($request->file('photo'))->save($path.$image);
            $path = $path.$image;

            $blog->image_url = $path;
        }

        if($blog->title != $request->input('title'))
            $this->validate($request, ['title' => 'unique:blogs']);
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->status = $request->input('status');

        $blog->save();

        $response = [
            'message' => 'Blog has been updated!'
        ];
        return response()->json($response ,201);
    }

    public function deleteBlog($bid){
        $blog = Blog::findOrFail($bid);

        $blog->delete();

        Storage::deleteDirectory('/blog/'.$bid);

        $response = [
            'message' => 'Blog has been deleted!'
        ];
        return response()->json($response ,201);
    }
}
