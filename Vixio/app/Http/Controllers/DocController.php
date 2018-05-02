<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DocumentationTitle;
use App\DocumentationSubtitle;
use App\DocumentationContent;
class DocController extends Controller
{
    public function getTableOfContent(){
        $docs = DocumentationTitle::with(['subtitle:id,title_id,subtitle', 'subtitle.content:subtitle_id,header,content'])->get(['id','title']);

        return response()->json($docs, 200);
    }

    //admin
    public function adminGetTitle(){
        $title = DocumentationTitle::with(['subtitle:id,title_id,subtitle'])->get(['id','title']);

        return response()->json($title, 200);
    }

    public function adminGetAll(){
        $docs = DocumentationTitle::with(['subtitle:id,title_id,subtitle', 'subtitle.content:subtitle_id,header,content'])->get(['id','title']);

        return response()->json($docs, 200);
    }

    public function createTitle(Request $request){
    	$this->validate($request, [
			'title' => 'required|unique:documentation_titles',
		]);

		$docs = new DocumentationTitle();
		$docs->title = $request->input('title');
		$docs->save();

		$response = [
			'message' => 'Successfully created a new documentation!'
		];
		return response()->json($response ,201);
    }

    public function createSubtitle(Request $request){
    	$this->validate($request, [
    		'titleID' => 'required',
			'subtitle' => 'required',
		]);

		$docs = new DocumentationSubtitle();
		$docs->title_id = $request->input('titleID');
		$docs->subtitle = $request->input('subtitle');
		$docs->save();

		$response = [
			'message' => 'Successfully created a new documentation!'
		];
		return response()->json($response ,201);
    }

    public function createContent(Request $request){
    	$this->validate($request, [
    		'subtitleID' => 'required',
			'header' => 'required',
			'content' => 'required'
		]);

		$docs = new DocumentationContent();
		$docs->subtitle_id = $request->input('subtitleID');
		$docs->header = $request->input('header');
		$docs->content = $request->input('content');
		$docs->save();

		$response = [
			'message' => 'Successfully created a new documentation!'
		];
		return response()->json($response ,201);
    }

    public function adminUpdate(Request $request, $tid, $sid = null, $hid = null){
        if(!is_null($hid)){
            $this->validate($request, [
                'titleID' => 'required',
                'subtitleID' => 'required',
                'header' => 'required',
                'content' => 'required'
            ]);

            $content = DocumentationContent::findOrFail($hid);

            $content->subtitle_id = $request->input('subtitleID');
            $content->header = $request->input('header');
            $content->content = $request->input('content');

            $content->save();

        }else if(!is_null($sid)){
            $this->validate($request, [
                'titleID' => 'required',
                'subtitle' => 'required'
            ]);

            $subtitle = DocumentationSubtitle::findOrFail($sid);

            $subtitle->title_id = $request->input('titleID');
            $subtitle->subtitle = $request->input('subtitle');

            $subtitle->save();
        }else{
            $this->validate($request,[
                'title' => 'required'
            ]);

            $title = DocumentationTitle::findOrFail($tid);

            $title->title = $request->input('title');

            $title->save();
        }

        $response = [
            'message' => 'Successfully update the document!'
        ];
        return response()->json($response ,201);
    }

    public function adminDelete($tid, $sid = null, $hid = null){
        if(!is_null($hid)){
            $content = DocumentationContent::findOrFail($hid);

            $content->delete();

        }else if(!is_null($sid)){
            $subtitle = DocumentationSubtitle::findOrFail($sid);

            $subtitle->delete();
            
        }else{
            $title = DocumentationTitle::findOrFail($tid);

            $title->delete();
        }

        $response = [
            'message' => 'Successfully update the document!'
        ];
        return response()->json($response ,201);
    }
}
