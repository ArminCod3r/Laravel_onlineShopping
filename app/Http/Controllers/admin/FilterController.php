<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class FilterController extends Controller
{
	private $categories = array();
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$categories = self::categoryTree();

    	return view('admin/filter/index')->with('categories', $categories);
    }



    // Recursive Method to get all the categories/subcategories
    private function categoryTree($parent_id = 0, $sub_mark = '')
    {
        $query = DB::table('category')
                ->select('*')
                ->where('parent_id',$parent_id)
                ->get()
                ->pluck('cat_name','id');

        
        foreach ($query as $id => $value)
        {
            //echo $key." : ".$sub_mark.$value."</br>";
            array_push($this->categories, $sub_mark.$value.':'.$id);
            $this->categoryTree($id, $sub_mark.'---');
        }
        return $this->categories;
    }
}
