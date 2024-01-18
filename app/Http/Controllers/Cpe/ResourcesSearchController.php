<?php
  
namespace App\Http\Controllers\Cpe;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Search;
  
class ResourcesSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cpe.resultado-recursos');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = Search::select("search_item")
                ->where("search_item","LIKE","%{$request->input('query')}%")
                ->pluck('search_item');
   
        return response()->json($data);
    }
}