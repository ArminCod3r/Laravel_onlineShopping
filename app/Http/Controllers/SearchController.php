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


        $search_result = array();
        $brand  = array();
        $selected_filters = array();


        // processing brand[] in the URL
        if(array_key_exists('brand', $data))
        {
            $brand    = $data['brand'];
            $selected_filters = $data['brand'];

            // Query between tables: link_category_filter -> filter_assign -> product
            $products = DB::select("select *
                            from product
                            where id in (select product_id
                                         from filter_assign
                                         where value_id in(
                                                            SELECT filter_id
                                                            from link_category_filter
                                                            where category_id in (".implode(", ",$data['brand']).")))");
            
            // pop the brand[] from the url to get the rest of filters services
            unset($data['brand']);
            $conditions = array();

            // make a new array to store all the filters
            foreach ($data as $key => $value)
            {
                foreach ($value as $key_2 => $value_2)
                {
                    array_push($conditions, $value_2);
                    array_push($selected_filters, $value_2);
                }
            }

            // processing the other filters in the URL
            if( sizeof($conditions) > 0 )
            {
                // Query between tables: link_category_filter -> filter_assign -> product
                $products_2 = DB::select("select *
                            from product
                            where id in (select product_id
                                         from filter_assign
                                         where value_id in(
                                                            SELECT filter_id
                                                            from link_category_filter
                                                            where category_id in (".implode(", ",$conditions).")))");

                // comapring brands[]-results and the otherFilters[]-results
                // to get the ones that are in common with each other(comapre by products' id)
                // eg: brands[]      : 1,2,3
                //     otherFilters[]: 2,3
                // th result would be: 2,3
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

            // if no other filter impleneted, just add the brands[] filter as the search-result
            else
                $search_result = $products;

        }

        // get the images of the products. array with the key of the 'product_id'
        $images = array();
        foreach ($search_result as $key => $value)
        {
            $img = DB::select("select url
                            from product_images
                            where product_id=".$value->id." LIMIT 1");

            $images[$value->id]=$img[0];

        }

        // getting the list of the filters for the last category from the url
        $filters = Filter::where('category_id', $cat3->id)->get();



        // Getting the list of the category_filters
        $linking_filters = LinkCatFilter::all();
        $linked_filters  = array();

        // Changing the format of the category_filters
        foreach ($linking_filters as $key => $value)
        {
            $linked_filters[$value->category_id] = $value->filter_id;
        }


        // Get the names of the selected filters
        $selected_names = LinkCatFilter::with('FilterAssign')
                                       ->wherein('category_id',$selected_filters)
                                       ->get();
                                       


        return view("site/search/index")->with([
                                                'filters'        => $filters,
                                                'products'       => $search_result,
                                                'images'         => $images,
                                                'linked_filters' => $linked_filters,
                                                'selected_filters'=> $selected_filters,
                                                'selected_names'  => $selected_names,
                                              ]);


    }
}
