<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\ParentProduct;
use App\Filter;
use View;

class SearchController extends Controller
{
	private $categories = array();

	public function __construct()
	{
		$categories = Category::all();
        $categories = json_decode($categories, true);

		View::share('categories', $categories);
	}



    public function search(Request $request, $cat1=null, $cat2=null, $cat3=null)
    {
        $filters = Filter::select('ename')->get();

        $filter_name     = array();
        $filters_content = array();

        foreach ($filters as $key => $value)
        {
            $url_filter = $value->ename;

            if($request->has($url_filter))
            {
                array_push($filter_name, $url_filter);
                $filters_content[$url_filter] = $request->input($url_filter);
            }
        }

        return [$filter_name, $filters_content];
    }
}
