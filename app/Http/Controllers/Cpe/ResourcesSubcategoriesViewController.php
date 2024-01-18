<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\ResourcesSubcategory;
use App\Models\ResourcesCategory;


class ResourcesSubcategoriesViewController extends Controller
{
    public function index(){
        
        if((!isset($_GET['subcategoria'])) or (!ResourcesSubcategory::find($_GET['subcategoria'])) or(!isset($_GET['categoria'])) or(!ResourcesCategory::find($_GET['categoria']))){
			
			abort(403);
		
        }

	$subcategoria = $_GET['subcategoria'];
		
	$categoria = $_GET['categoria'];
        
    $subcategory = ResourcesSubcategory::find($subcategoria);
        
    $resourcesSubcategory = $subcategory->load('resourcescategory', 'resourceSubcategoryResources');
        
    $resources = $resourcesSubcategory->resourceSubcategoryResources;

	return view('cpe.ver-subcategoria',compact('resources','subcategory'));

	}
}
