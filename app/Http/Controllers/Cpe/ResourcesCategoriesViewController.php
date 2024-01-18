<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResourcesSubcategory;
use App\Models\ResourcesCategory;

class ResourcesCategoriesViewController extends Controller
{
    public function index(){
        
        if((!isset($_GET['categoria'])) or (!ResourcesCategory::find($_GET['categoria']))){
			
			abort(403);
		}
		
		$category = $_GET['categoria'];
        
		$resourcesSubcategories = ResourcesSubcategory::where('resourcescategory_id',$category)->get();
		$categorySend = ResourcesCategory::inRandomOrder()->where('id','<>',$category)->first();
		$categoryView = ResourcesCategory::find($category);
		
		return view('cpe.ver-categoria',compact('resourcesSubcategories','categorySend','categoryView','category'));
		
	}
}
