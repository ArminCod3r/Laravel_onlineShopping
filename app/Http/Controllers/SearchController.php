<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\ParentProduct;
use App\Filter;
use App\LinkCatFilter;
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


        //$condition_values = $data['os'];

        $search_result = array();
        $brand  = array();
        $selected_filters = array();

        if(array_key_exists('brand', $data))
        {
            $brand    = $data['brand'];
            $selected_filters = $data['brand'];

            $products = DB::select("select *
                            from product
                            where id in (select product_id
                                         from filter_assign
                                         where value_id in(
                                                            SELECT filter_id
                                                            from link_category_filter
                                                            where category_id in (".implode(", ",$data['brand']).")))");
            
            unset($data['brand']);
            $conditions = array();

            foreach ($data as $key => $value)
            {
                foreach ($value as $key_2 => $value_2)
                {
                    array_push($conditions, $value_2);
                    array_push($selected_filters, $value_2);
                }
            }

            if( sizeof($conditions) > 0 )
            {
                $products_2 = DB::select("select *
                            from product
                            where id in (select product_id
                                         from filter_assign
                                         where value_id in(
                                                            SELECT filter_id
                                                            from link_category_filter
                                                            where category_id in (".implode(", ",$conditions).")))");

                if( sizeof($products_2) > 0 )
                {
                    foreach ($products as $key_1 => $value_1)
                    {
                        foreach ($products_2 as $key_2 => $value_2)
                        {
                            if( $value_1->id == $value_2->id )
                            {
                                array_push($search_result, $value_2);
                            }
                        }
                    }
                }
            }

            else
                $search_result = $products;

        }

        $images = array();
        foreach ($search_result as $key => $value)
        {
            $img = DB::select("select url
                            from product_images
                            where product_id=".$value->id." LIMIT 1");

            $images[$value->id]=$img[0];

        }


        $filters = Filter::where('category_id', $cat3->id)->get();



        $linking_filters = LinkCatFilter::all();
        $linked_filters  = array();

        foreach ($linking_filters as $key => $value)
        {
            $linked_filters[$value->category_id] = $value->filter_id;
        }



        return view("site/search/index")->with([
                                                'filters'        => $filters,
                                                'products'       => $search_result,
                                                'images'         => $images,
                                                'linked_filters' => $linked_filters,
                                                'selected_filters'=> $selected_filters,
                                              ]);


    }
}
