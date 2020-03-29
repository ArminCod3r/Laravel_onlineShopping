<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\ParentProduct;
use App\Filter;
use App\LinkCatFilter;
use View;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

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

        $products_in_cat3 = $cat3->with(['Products_ID', 'Product'])->where('parent_id', $cat2->id)->first();
        $prices_range = array();

        foreach ($products_in_cat3['Product'] as $key => $value)
            array_push($prices_range, $value['price']);
        


        $page_cats    = array();
        $page_cats[1] = $cat1;
        $page_cats[2] = $cat2;
        $page_cats[3] = $cat3;



        $data         = $request->all();
        $products     = array();
        $cat4_filters = array();


        $search_result = array();
        $brand  = array();
        $selected_filters = array();
        $sortby=null;
        $sort_order = 'product.id DESC';

        $min_price = null;
        $max_price = null;


        // processing brand[] in the URL
        if(array_key_exists('brand', $data))
        {
            $brand    = $data['brand'];
            $selected_filters = $data['brand'];

            if(isset($data['sortby']))
            {
                if($data['sortby']>0 and $data['sortby']<6)
                {
                    $sortby = $data['sortby'];

                    switch ($sortby)
                    {
                        case 1:  $sort_order = 'product.id            DESC';  break;
                        case 2:  $sort_order = 'product.order_product ASC' ;  break;
                        case 3:  $sort_order = 'product.price         ASC' ;  break;
                        case 4:  $sort_order = 'product.price         DESC';  break;
                        case 5:  $sort_order = 'product.view          DESC';  break;
                        default: $sort_order = 'product.id            DESC';  break;
                    }
                }
            }

            if(isset($data['min_price'])) $min_price = $data['min_price'];

            if(isset($data['max_price'])) $max_price = $data['max_price'];



            // Query between tables: link_category_filter -> filter_assign -> product
            $products = DB::table('product')
                      ->join('filter_assign', 'product.id', '=', 'filter_assign.product_id')
                      ->join('link_category_filter', 'filter_assign.value_id', '=', 'link_category_filter.filter_id')
                      ->wherein('link_category_filter.category_id', $data['brand'])
                      ->where(function ($q) use($max_price) { // execute if max_price != null
                            if ($max_price) {
                                $q->where('product.price', '<=', $max_price);
                            }
                        })
                      ->where(function ($q) use($min_price) { // execute if min_price != null
                            if ($min_price) {
                                $q->where('product.price', '>=', $min_price);
                            }
                        })
                      ->orderByRaw($sort_order) //17006309
                      ->get();
            
            // pop the brand[], page[] from the url to get the rest of filters services
            unset($data['brand']);
            unset($data['page']);

            if(isset($data['sortby']))
                unset($data['sortby']); 

            if(isset($data['min_price'])) unset($data['min_price']);

            if(isset($data['max_price'])) unset($data['max_price']);


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
                $products_2 = DB::table('product')
                      ->join('filter_assign', 'product.id', '=', 'filter_assign.product_id')
                      ->join('link_category_filter', 'filter_assign.value_id', '=', 'link_category_filter.filter_id')
                      ->wherein('link_category_filter.category_id', $conditions)
                      ->get();

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
                            if( $value_1->product_id == $value_2->product_id )
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
                            where product_id=".$value->product_id." LIMIT 1");

            $images[$value->product_id]=$img[0];

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
                                       
       
        


        // pagination
        // Array pagination: source: https://arjunphp.com/laravel-5-pagination-array/

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($search_result);
 
        // Define how many items we want to be visible in each page
        $perPage = 20;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url()); 

        $search_result = $paginatedItems;


        return view("site/search/index")->with([
                                                'filters'        => $filters,
                                                'products'       => $search_result,
                                                'images'         => $images,
                                                'linked_filters' => $linked_filters,
                                                'selected_filters'=> $selected_filters,
                                                'selected_names'  => $selected_names,
                                                'page_cats'       => $page_cats,
                                                'sortby'          => $sortby,
                                                'prices_range'    => $prices_range,
                                              ]);


    }
}
