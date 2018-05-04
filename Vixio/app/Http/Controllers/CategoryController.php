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

		$response = [
			'message' => 'Successfully created a new category genre!'
		];
		return response()->json($response ,201);
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

		$response = [
			'message' => 'Successfully created a new category type!'
		];
		return response()->json($response ,201);
    }
    
    public function adminGetGenre(){
    	$genres = CategoryGenre::all(['id','genre']);

    	// return view('')->with('data', $genres);

    	return response()->json($genres, 200);
    }

    public function adminGetType(){
    	$types = CategoryType::with(['categoryGenre:id,genre'])->get(['genre_id','name']);

    	return response()->json($types, 200);
    }

    public function adminUpdateGenre(Request $request, $gid){
    	$this->validate($request, [
    		'genre' => 'required|unique:category_genres'
		]);

		$genre = CategoryGenre::findOrFail($gid);
		$genre->genre = $request->input('genre');

		$genre->save();

		$response = [
			'message' => 'Category genre has been changed!'
		];
		return response()->json($response ,201);
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

		$response = [
			'message' => 'Category type has been changed!'
		];
		return response()->json($response ,201);
    }

    public function adminDeleteGenre($gid){
    	if($gid != 1){
    		$type = CategoryType::where('genre_id', '=', $gid)->update(['genre_id' => 1]);

			$genre = CategoryGenre::find($gid);

			$genre->delete();

			$response = [
				'message' => 'Category genre has been deleted!'
			];
			return response()->json($response ,201);
    	}
    	$response = [
				'message' => 'Cannot delete "Uncategorized" genre'
			];
			return response()->json($response ,201);
		
    }

    public function adminDeleteType($tid){
		$type = CategoryType::findOrFail($tid);

		$type->delete();

		$response = [
			'message' => 'Category type has been deleted!'
		];
		return response()->json($response ,201);
    }
}
