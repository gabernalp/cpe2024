<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Tag;


class ResultadoBusquedaRecursosController extends Controller
{
    public function index(Request $request){

	$sterm = $request->input('search_item');
        
    $terms = array();
                
    $allResources = array();
        
    $allTags = array();
        
    $propositions = array('a', 'ante', 'bajo', 'cabe', 'con', 'contra', 'de', 'desde', 'durante', 'en', 'entre', 'hacia', 'hasta', 'mediante', 'para', 'por', 'según', 'sin', 'so', 'sobre', 'tras', 'versus', 'vía');
        
    $expSterms = explode(' ',$sterm);
                
    $t = 0;
        
    while($t < count($expSterms)){
        
        if(!in_array($expSterms[$t], $propositions)){
            
            array_push($terms,$expSterms[$t]);
            
        }
        
        $t = $t + 1;
    }
    
        
    foreach($terms as $term){
        
        $nameDescriptionResults = Resource::where('name','like','%'.$term.'%')->orWhere('comments','like','%'.$term.'%')->get();
                        
        foreach($nameDescriptionResults as $nameDescriptionResult){
            
            array_push($allResources,$nameDescriptionResult->id);
            
        }
                                
        if($tags = Tag::where('name','like','%'.$term.'%')->get()){
                        
            
            foreach($tags as $tag){
                
                $tagSearch = Tag::find($tag->id);
                
                $tagElements = $tagSearch->load('tag_category', 'tagsResources');
            
                $tagResources = $tagElements->tagsResources;

                //dd($tagResources);

                foreach($tagResources as $tagResource){

                    array_push($allResources,$tagResource->id);

                }
                
            }

        }                              
              
    }
    
    $resourceIds = array_unique($allResources);
        
      //  dd($resourceIds);
    
    if(count($resourceIds) < 1){
        
        $resourceIds = false;
    
    }
        
    $resourceRands = Resource::inRandomOrder()->take(6)->get();
	   

    return view('cpe.resultado-busqueda-recursos',compact('resourceIds','sterm','resourceRands'));

	}
    
}
