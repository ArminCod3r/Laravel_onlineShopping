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



        $data         = $request->all();
        $products     = array();
        $cat4_filters = array();

        if(array_key_exists('brand', $data))
        {
            $brand = $data['brand'];

            if(sizeof($brand) == 1)
            {
                $products = ParentProduct::where('parent_id', $data['brand'])->with('Product')->with('ProductImage')->get();

                $filters = Filter::where('category_id', $cat3->id)->get();
            }
            
            if(sizeof($brand) > 1)
            {
                foreach ($brand as $key => $value) { $arr[] = $value; }
                $brands = $arr;
                $condition_values = array();


                unset($data['brand']);

                // Making an array of conditions
                foreach ($data as $key => $value)
                {
                    foreach ($value as $key_2 => $value_2)
                    {
                        array_push($condition_values, $value_2);
                    }
                }

                // Checking other filters has sent
                if( sizeof($condition_values) > 0 )
                {
                    // get the products with affected filters ('brands' will not count)
                    $products = ParentProduct::whereIn('parent_id', $brands)->with('Product')->with('ProductImage')->with(["FilterAssign" => function($q) use ($condition_values){
                                        $q->wherein('filter_assign.value_id', $condition_values);
                                    }])->get();

                    // unset an item which has an empty 'FilterAssign'
                    foreach ($products as $key => $value)
                    {
                        if( sizeof($value['FilterAssign']) == 0 )
                        {
                            unset($products[$key]);
                        }
                    }

                }
                else
                    $products = ParentProduct::whereIn('parent_id', $brands)->with('Product')->with('ProductImage')->get();
                

                // if brands are more than one, we should get the parent's filters
                $filters = Filter::where('category_id', $cat3->id)->get();

            }
            
        }

        // TODO : Dynamic brands' names
        $brands_names = array();
        $brands_names[13] = 80;
        $brands_names[16] = 70;
        $brands_names[15] = 66;
        $brands_names[25] = 82;
        $brands_names[27] = 83;
        $brands_names[28] = 81;
        $brands_names[29] = 84;
        $brands_names[23] = 91;
        

        return view("site/search/index")->with([
                                                'filters'        => $filters,
                                                'products'       => $products,
                                                'brands_names'   => $brands_names,
                                                'selected_brands'=> $brand,
                                              ]);


    }
}
