<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Category;

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

    	if($request->get('id'))
    	{
    		$selected_id = $request->get('id');
    		return view('admin/filter/index')->with(['categories'  => $categories,
    												 'selected_id' => $selected_id,
    												 ]);
    	}

    	else
    		return view('admin/filter/index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$id = $request->get('id');
    	$category = Category::findOrFail($id);

    	$filter_name_parent  = $request->get('filter_name_parent');
    	$filter_ename_parent = $request->get('filter_ename_parent');
    	$select_option       = $request->get('parent_option');

    	foreach ($filter_name_parent as $key => $value)
    	{
    		if ($key<0 && !empty($value))
    		{
    			$ename = array_key_exists($key, $filter_ename_parent) ? $filter_ename_parent[$key] : '';
    			$selected_item = array_key_exists($key, $select_option) ? $select_option[$key] : 1;

    			DB::table('filter')->insert(
				    ['category_id' => $id    ,
				     'name'       => $value ,
				     'ename' 	   => $ename ,
				     'parent_id'   => 0      ,
				     'filled' 	   => $selected_item,
				     ]
				);

				echo 'inserted <br>';
    		}
    	}

    	//return $request->all();
    	//return [$selected_option, $request->all()];
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
