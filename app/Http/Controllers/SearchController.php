<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\ParentProduct;
use App\Filter;
use View;
use DB;

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
        $brand = $request->all('brand');
        $color = $request->all('color');


        /*$arr = array();
        foreach ($brand as $key => $value) { $arr[] = $value; }
        $brand = $arr;

        $categories = Category::whereIn('id', $brand[0])->get();

        return $categories;*/

        $cat1 = Category::where('cat_ename', $cat1)->firstOrFail();

        $cat2 = Category::where([
                                    'cat_ename' => $cat2,
                                    'parent_id' => $cat1->id,
                                ])
                                ->firstOrFail();

        $cat3 = Category::where([
                                    'cat_ename' => $cat3,
                                    'parent_id' => $cat2->id,
                                ])
                                ->firstOrFail();

        
        // changing the $brands data format for 'whereIn' query-> whereIn: NO:(1,2,3) Yes:[1,2,3]
        $arr = array();
        foreach ($brand as $key => $value) { $arr[] = $value; }
        $brand = $arr;

        $arr = array();
        foreach ($brand as $key => $value) { $arr[] = $value; }
        $brand = $arr;


        if( sizeof($brand) > 0 )
        {
            $products = ParentProduct::whereIn('parent_id', $brand[0])->with('Product')->with('ProductImage')->with(["FilterAssign" => function($q){
                                    $q->wherein('filter_assign.value_id', [68,69]);
                                }])->get();
        }

        $cat4_filters = Filter::whereIn('category_id', $brand[0])->get();

        //return $cat4_filters;

        return view("site/search/index")->with([
                                                'cat3_filters'=> $cat4_filters,
                                                'products'    => $products,
                                              ]);






        /*$filters = Filter::select('ename')->get();

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

        return [$filter_name, $filters_content];*/
    }
}
