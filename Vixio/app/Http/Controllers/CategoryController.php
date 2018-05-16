<?php

namespace App\Http\Controllers;

use App\CategoryGenre;
use App\CategoryType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class CategoryController extends Controller
{
    public function getGenre(){
    	$genres = CategoryGenre::where('id','!=',1)->with(['categoryType:id,genre_id,name'])->has('categoryType','>',0)->get(['id','genre']);

    	return response()->json($genres, 200);
    }

    //admin
	public function createGenre(Request $request){
    	$this->validate($request, [
    		'genre' => 'required|unique:category_genres'
		]);
		$genre = new CategoryGenre();
		$genre->genre = $request->input('genre');
		$genre->save();

        $request->session()->flash('message', 'New genre has been created');

		return back();
    }

    public function createType(Request $request){
    	$this->validate($request, [
    		'genreID' => 'required',
    		'name' => 'required|unique:category_types'
		]);
		$type = new CategoryType();
		$type->genre_id = $request->input('genreID');
		$type->name = $request->input('name');
		$type->save();

        $request->session()->flash('message', 'New type has been created!');

		return back();
    }
    
    public function adminGetGenre(){
    	$genres = CategoryGenre::all(['id','genre']);

    	return view('/pages/categoryGenre')->with('data', $genres);
    }

    public function adminGetType(){
    	$types = CategoryType::with(['categoryGenre:id,genre'])->get(['id','genre_id','name']);

    	$genres = CategoryGenre::all(['id','genre']);

    	$data = [
    		'types' => $types,
    		'genres' => $genres,
    	];

    	return view('/pages/categoryType')->with('data', $data);
    }

    public function adminUpdateGenre(Request $request, $gid){
    	$this->validate($request, [
    		'genre' => 'required|unique:category_genres'
		]);

		$genre = CategoryGenre::findOrFail($gid);
		$genre->genre = $request->input('genre');

		$genre->save();

        $request->session()->flash('message', 'Genre updated successfully');

		return back();
    }

    public function adminUpdateType(Request $request, $tid){
    	$this->validate($request, [
    		'genreID' => 'required',
    		'name' => 'required|unique:category_types'
		]);

		$type = CategoryType::findOrFail($tid);
		$type->genre_id = $request->input('genreID');
		$type->name = $request->input('name');

		$type->save();

        $request->session()->flash('message', 'Type updated successfully');

		return back();
    }

    public function adminDeleteGenre(Request $request, $gid){
    	if($gid != 1){
    		$type = CategoryType::where('genre_id', '=', $gid)->update(['genre_id' => 1]);

			$genre = CategoryGenre::find($gid);

			$genre->delete();

            $request->session()->flash('message', 'Genre deleted successfully');
    	}

    	return back();
		
    }

    public function adminDeleteType(Request $request, $tid){
		$type = CategoryType::findOrFail($tid);

		$type->delete();

        $request->session()->flash('message', 'Type deleted successfully');

		return back();
    }
}
