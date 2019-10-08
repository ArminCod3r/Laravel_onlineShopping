<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use DB;

class SiteController extends Controller
{
	public function __construct()
	{

	}

    public function index()
    {
    	return view('site.index');
    }

    public function categoryTree($parent_id = 0, $sub_mark = '')
    {

	    $query = DB::table('category')
                ->select('*')
                ->where('parent_id',$parent_id)
                ->get()
                ->pluck('cat_ename','id');

        /*echo $query;
        echo gettype($query);
        echo $query['2'];*/

        foreach ($query as $key => $value)
        {
        	echo $key." : ".$sub_mark.$value."</br>";
        	$this->categoryTree($key, $sub_mark.'---');
        }

	}


}
