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



    public function search(Request $request, $cat1=null, $cat2=null, $cat3=null, $cat_4=null)
    {
    	$cat4 = $request->get('q');

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

    	$cat3_filters = array();    	
    	if( sizeof($cat4) > 0 )
    	{
    		$cat3_filters = Filter::where('category_id', $cat3->id)->get();
    	}

        $cat4 = Category::where([
                                    'cat_ename' => $cat4,
                                    'parent_id' => $cat3->id,
                                ])
                                ->firstOrFail();

        $products = ParentProduct::with('Product')->with('ProductImage')
                                 ->where('parent_id', $cat4->id)
                                 ->get();
                                 

    	return view("site/search/index")->with([
                                                'cat3_filters'=> $cat3_filters,
                                                'products'    => $products,
                                              ]);
    }
}
