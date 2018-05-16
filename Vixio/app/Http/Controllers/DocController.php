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
        $title = DocumentationTitle::get(['id','title']);

        return view('/pages/documentationTitle')->with('data', $title);
    }

    public function adminGetSubtitle(){
        $title = DocumentationTitle::get(['id','title']);

        $subtitle = DocumentationSubtitle::with(['title:id,title'])->get(['id','title_id','subtitle']);

        $data = [
            'title' => $title,
            'subtitle' => $subtitle
        ];

        return view('/pages/documentationSubtitle')->with('data', $data);
    }

    public function adminGetContent(){
        $title = DocumentationTitle::get(['id','title']);

        $subtitle = DocumentationSubtitle::with(['title:id,title'])->get(['id','title_id','subtitle']);

        $content = DocumentationContent::with(['subtitle:id,title_id,subtitle','subtitle.title:id,title'])->get(['id','subtitle_id','header','content']);

        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'content' => $content
        ];

        return view('/pages/documentationContent')->with('data', $data);
    }

    public function createTitle(Request $request){
    	$this->validate($request, [
			'title' => 'required|unique:documentation_titles',
		]);

		$docs = new DocumentationTitle();
		$docs->title = $request->input('title');
		$docs->save();

        $request->session()->flash('message', 'New title has been created');

		return back();
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

        $request->session()->flash('message', 'New subtitle has been created');

		return back();
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

        $request->session()->flash('message', 'New content has been created');

		return back();
    }

    public function adminUpdate(Request $request, $tid, $sid = null, $hid = null){
        if(!is_null($hid)){
            $this->validate($request, [
                'subtitleID' => 'required',
                'header' => 'required',
                'content' => 'required'
            ]);

            $content = DocumentationContent::findOrFail($hid);

            $content->subtitle_id = $request->input('subtitleID');
            $content->header = $request->input('header');
            $content->content = $request->input('content');

            $content->save();

            $request->session()->flash('message', 'Content updated successfully');

        }else if(!is_null($sid)){
            $this->validate($request, [
                'titleID' => 'required',
                'subtitle' => 'required'
            ]);

            $subtitle = DocumentationSubtitle::findOrFail($sid);

            $subtitle->title_id = $request->input('titleID');
            $subtitle->subtitle = $request->input('subtitle');

            $subtitle->save();

            $request->session()->flash('message', 'Subtitle updated successfully');
        }else{
            $this->validate($request,[
                'title' => 'required'
            ]);

            $title = DocumentationTitle::findOrFail($tid);

            $title->title = $request->input('title');

            $title->save();

            $request->session()->flash('message', 'Title updated successfully');
        }

        return back();
    }

    public function adminDelete(Request $request, $tid, $sid = null, $hid = null){
        if(!is_null($hid)){
            $content = DocumentationContent::findOrFail($hid);

            $content->delete();

            $request->session()->flash('message', 'Content deleted successfully');

        }else if(!is_null($sid)){
            $subtitle = DocumentationSubtitle::findOrFail($sid);

            $subtitle->delete();

            $request->session()->flash('message', 'Subtitle deleted successfully');
            
        }else{
            $title = DocumentationTitle::findOrFail($tid);

            $title->delete();

            $request->session()->flash('message', 'Title deleted successfully');
        }

        return back();
    }
}
