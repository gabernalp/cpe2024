<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResourcesCategory;
use App\Models\Banner;


class ResourcesCategoriesController extends Controller
{
    public function index(){
		
		$resourcesCategories = ResourcesCategory::get();
		
		$banners = Banner::where('position',2)->get();

		
		return view('cpe.recursos',compact('resourcesCategories','banners'));
		
	}
}
